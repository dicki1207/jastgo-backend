<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\AlurDana;
use App\Models\Barang;
use App\Notifications\DanaDilepaskan;
use App\Notifications\PembayaranDikonfirmasi;
use App\Notifications\PembayaranBerhasilDikonfirmasi;
use App\Notifications\PembayaranDitolak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranAdminController extends Controller
{
    public function daftarKonfirmasiPembayaran(Request $request)
    {
        $search = $request->query('search');

        // Menampilkan semua pesanan yang dananya sedang ditahan di sistem (TERTAHAN)
        // Admin hanya bisa melepaskan dana jika status_pesanan == 'SELESAI' (di-handle di View)
        $query = Pesanan::where('status_dana_jastiper', 'TERTAHAN')
                        ->with(['pembayaranUser', 'user', 'jastiper', 'detailPesanans']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q_user) use ($search) {
                      $q_user->where('name', 'like', "%{$search}%")
                             ->orWhere('username', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jastiper', function ($q_jastiper) use ($search) {
                      $q_jastiper->where('nama_toko', 'like', "%{$search}%");
                  });
            });
        }

        $pesanans = $query->orderBy('created_at', 'desc')
                          ->paginate(10)
                          ->appends(['search' => $search]);

        // Fetch admin's active bank accounts to be used for the manual transfer dropdown
        $adminRekenings = \App\Models\Rekening::where('user_id', Auth::id())
                                              ->where('status_aktif', 'aktif')
                                              ->get();

        return view('admin.konfirmasi-dana.index', compact('pesanans', 'search', 'adminRekenings'));
    }

    /**
     * ================================
     * KONFIRMASI PEMBAYARAN USER
     * (STOK DIKURANGI DI SINI)
     * ================================
     */
    public function konfirmasiPembayaran(Pesanan $pesanan)
    {
        if ($pesanan->status_pesanan !== 'MENUNGGU_KONFIRMASI_ADMIN') {
            return back()->with('error', 'Pesanan tidak dalam status yang dapat dikonfirmasi.');
        }

        try {
            DB::beginTransaction();

            $pembayaran = $pesanan->pembayaranUser;

            if (!$pembayaran) {
                throw new \Exception('Data pembayaran user tidak ditemukan.');
            }

            /**
             * STOK SUDAH DIKURANGI DI CHECKOUT
             * Dihapus agar tidak double deduction
             */

            /**
             * UPDATE PEMBAYARAN
             */
            $pembayaran->update([
                'status_konfirmasi' => 'DIKONFIRMASI',
                'konfirmator_id'    => Auth::id(),
            ]);

            /**
             * UPDATE PESANAN
             */
            $pesanan->update([
                'status_pesanan'       => 'DIPROSES',
                'status_dana_jastiper' => 'TERTAHAN',
            ]);

            DB::commit();

            // 🔔 Notifikasi
            $pesanan->jastiper->notify(new PembayaranDikonfirmasi($pesanan));
            $pesanan->user->notify(new PembayaranBerhasilDikonfirmasi($pesanan));

            return back()->with(
                'success',
                'Pembayaran berhasil dikonfirmasi.'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * ================================
     * TOLAK PEMBAYARAN
     * ================================
     */
    public function tolakPembayaran(Pesanan $pesanan)
    {
        if ($pesanan->status_pesanan !== 'MENUNGGU_KONFIRMASI_ADMIN') {
            return back()->with('error', 'Pesanan tidak dalam status yang dapat ditolak.');
        }

        try {
            DB::beginTransaction();

            $pembayaran = $pesanan->pembayaranUser;

            if (!$pembayaran) {
                throw new \Exception('Data pembayaran user tidak ditemukan.');
            }

            $pembayaran->update([
                'status_konfirmasi' => 'DITOLAK',
                'konfirmator_id'    => Auth::id(),
            ]);

            $pesanan->update([
                'status_pesanan' => 'DIBATALKAN',
            ]);

            // Kembalikan Stok Barang!
            foreach ($pesanan->detailPesanans as $detail) { 
                $barang = Barang::lockForUpdate()->find($detail->barang_id);
                if ($barang) {
                    $barang->stok += $detail->jumlah;
                    $barang->save();
                }
            }

            DB::commit();

            $pesanan->user->notify(new PembayaranDitolak($pesanan));

            return back()->with('success', 'Pembayaran ditolak dan pesanan dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * ================================
     * LEPAS DANA KE JASTIPER
     * ================================
     */
    public function lepasDanaKeJastiper(Request $request, Pesanan $pesanan)
    {
        try {
            DB::beginTransaction();

            // KUNCI BARIS INI (Pencegahan Race Condition)
            $lockedPesanan = Pesanan::lockForUpdate()->find($pesanan->id);

            if ($lockedPesanan->status_pesanan !== 'SELESAI' || $lockedPesanan->status_dana_jastiper !== 'TERTAHAN') {
                DB::rollBack();
                return back()->with('error', 'Dana tidak valid untuk diteruskan (mungkin sudah diteruskan atau belum selesai).');
            }

            $biayaAdmin   = $lockedPesanan->total_harga * 0.05;
            $jumlahBersih = $lockedPesanan->total_harga - $biayaAdmin;

            AlurDana::create([
                'pesanan_id'        => $lockedPesanan->id,
                'jenis_transaksi'   => 'PELEPASAN_DANA', // Logika lama tetap dipakai untuk history pendapatan
                'jumlah_dana'       => $jumlahBersih,
                'bukti_tf_path'     => 'Masuk Dompet (Sistem)',
                'status_konfirmasi' => 'DIKONFIRMASI',
                'konfirmator_id'    => Auth::id(),
                'tanggal_transfer'  => now(),
                'biaya_admin'       => $biayaAdmin,
            ]);

            // Ubah status dana menjadi TERSEDIA_DI_DOMPET
            $lockedPesanan->update([
                'status_dana_jastiper' => 'TERSEDIA_DI_DOMPET',
            ]);

            DB::commit();

            // Opsional: Kirim notifikasi dana sudah masuk dompet
            $lockedPesanan->jastiper->notify(
                new DanaDilepaskan($lockedPesanan, $jumlahBersih, $biayaAdmin)
            );

            return back()->with('success', 'Dana berhasil dilepaskan ke dompet Jastiper.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * ================================
     * TOLAK REKENING JASTIPER (MANUAL)
     * ================================
     */
    public function tolakRekeningJastiper(Request $request, Pesanan $pesanan)
    {
        if ($pesanan->status_pesanan !== 'SELESAI' || $pesanan->status_dana_jastiper === 'DILEPASKAN') {
            return back()->with('error', 'Status pesanan tidak valid.');
        }

        $request->validate([
            'catatan_admin' => 'required|string|max:255'
        ], [
            'catatan_admin.required' => 'Catatan/alasan penolakan rekening wajib diisi.'
        ]);

        try {
            DB::beginTransaction();

            // Kita biarkan status dana tetap TERTAHAN, tapi kita kirim notifikasi
            // ATAU bisa juga kita ubah status_dana_jastiper ke 'REKENING_INVALID'
            // Untuk amannya, biarkan TERTAHAN dan kirim notifikasi saja.

            DB::commit();

            // Kirim notifikasi ke Jastiper
            $pesanan->jastiper->notify(
                new \App\Notifications\RekeningJastiperSalah($pesanan, $request->catatan_admin)
            );

            return back()->with('success', 'Berhasil melaporkan rekening salah. Notifikasi telah dikirim ke Jastiper.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}