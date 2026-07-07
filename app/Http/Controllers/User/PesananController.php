<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Jastiper;
use App\Models\Ulasan;
use App\Models\AlurDana;
use Illuminate\Support\Facades\Notification; 
use App\Notifications\PesananSelesaiAdmin; 
use App\Notifications\PesananSelesaiJastiper;

class PesananController extends Controller
{
    public function riwayat(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $q = $request->query('q');
        
        $status = $request->query('status'); 
        
        $query = Pesanan::with(['user', 'jastiper', 'detailPesanans.barang'])
            ->where('user_id', $userId)
            ->orderBy('tanggal_pesan', 'desc');

        if ($status) {
            if ($status === 'DIBATALKAN') {
                $query->whereIn('status_pesanan', ['BATAL', 'DIBATALKAN_REFUND']);
            } else if ($status === 'DIPROSES') {
                $query->whereIn('status_pesanan', ['MENUNGGU_KONFIRMASI_PEMBAYARAN', 'MENUNGGU_CEK', 'DIPROSES']);
            } else {
                $query->where('status_pesanan', $status);
            }
        }

        if ($q) {
            $query->where(function($w) use ($q){
                $w->where('id', 'like', "%{$q}%")
                  ->orWhere('no_hp', 'like', "%{$q}%")
                  ->orWhere('alamat_pengiriman', 'like', "%{$q}%")
                  ->orWhereHas('detailPesanans.barang', function($qBarang) use ($q) {
                      $qBarang->where('nama_barang', 'like', "%{$q}%");
                  });
            });
        }
        
        $pesanans = $query->paginate(10)->withQueryString();

        $user = Auth::user();
        $userName = $user->name ?? 'Pengguna';
        $cartCount = count(session('cart', []));

        return view('user.pesanan.riwayat', compact('pesanans', 'q', 'status', 'userName', 'cartCount'));
    }

    public function show(Pesanan $pesanan)
    {
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan. Pesanan bukan milik Anda.');
        }

        $pesanan->load(['user', 'jastiper', 'detailPesanans.barang', 'alurDana']);
        
        return view('user.pesanan.show', compact('pesanan'));
    }
    
    public function completeOrder(Request $request, $id)
    {
        $pesanan = Pesanan::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($pesanan->status_pesanan !== 'SIAP_DIKIRIM') {
            return back()->with('error', 'Pesanan tidak dalam status siap dikirim.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
            'foto_ulasan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();
            
            // 1. Update Status
            $pesanan->update([
                'status_pesanan' => 'SELESAI', 
                'has_reviewed' => true,
                'status_dana_jastiper' => 'TERSEDIA_DI_DOMPET' // Dana otomatis dirilis ke dompet
            ]);
            
            // 2. Catat riwayat dana otomatis
            $biayaAdmin   = $pesanan->total_harga * 0.05;
            $jumlahBersih = $pesanan->total_harga - $biayaAdmin;

            AlurDana::create([
                'pesanan_id'        => $pesanan->id,
                'jenis_transaksi'   => 'PELEPASAN_DANA', 
                'jumlah_dana'       => $jumlahBersih,
                'bukti_tf_path'     => 'Masuk Dompet (Otomatis Sistem)',
                'status_konfirmasi' => 'DIKONFIRMASI',
                'konfirmator_id'    => null, // Sistem yang konfirmasi
                'tanggal_transfer'  => now(),
                'biaya_admin'       => $biayaAdmin,
            ]);

            if ($pesanan->jastiper) {
                $pesanan->jastiper->notify(new PesananSelesaiJastiper($pesanan));
            }

            $admins = User::where('role', 'admin')->get(); 
            if ($admins->count() > 0) {
                Notification::send($admins, new PesananSelesaiAdmin($pesanan));
            }

            // 2. Simpan Ulasan
            $fotoPath = null;
            if ($request->hasFile('foto_ulasan')) {
                $fotoPath = $request->file('foto_ulasan')->store('ulasans', 'public');
            }

            Ulasan::create([
                'pesanan_id' => $pesanan->id,
                'user_id' => Auth::id(),
                'jastiper_id' => $pesanan->jastiper_id, 
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'foto_ulasan' => $fotoPath,
                'tanggal_ulasan' => now(),
            ]);

            // Update rating Jastiper
            if ($pesanan->jastiper_id) {
                $jastiper = \App\Models\Jastiper::find($pesanan->jastiper_id);
                if ($jastiper) {
                    $avgRating = \App\Models\Ulasan::where('jastiper_id', $jastiper->id)->avg('rating');
                    $jastiper->rating = $avgRating;
                    $jastiper->save();
                }
            }

            DB::commit();
            return back()->with('success', 'Pesanan berhasil diselesaikan dan ulasan telah disimpan. Terima kasih!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyelesaikan pesanan: ' . $e->getMessage());
        }
    }

    public function ajukanKomplain(Request $request, $id)
    {
        $pesanan = Pesanan::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($pesanan->status_pesanan !== 'SIAP_DIKIRIM') {
            return back()->with('error', 'Komplain hanya bisa diajukan untuk pesanan yang sudah dikirim.');
        }

        $request->validate([
            'alasan' => 'required|string|max:1000',
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:5120', // max 5MB
        ]);

        try {
            DB::beginTransaction();

            $fotoPath = $request->file('bukti_foto')->store('komplains', 'public');

            \App\Models\Komplain::create([
                'pesanan_id' => $pesanan->id,
                'user_id' => Auth::id(),
                'alasan' => $request->alasan,
                'bukti_foto' => $fotoPath,
                'status' => 'PENDING'
            ]);

            $pesanan->update([
                'status_pesanan' => 'KOMPLAIN'
            ]);

            // Notify Admins
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\KomplainBaruAdmin($pesanan));

            DB::commit();
            return back()->with('success', 'Komplain berhasil diajukan. Dana ditahan sementara Admin meninjau laporan Anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengajukan komplain: ' . $e->getMessage());
        }
    }
}