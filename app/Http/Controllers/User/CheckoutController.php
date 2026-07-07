<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Barang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Rekening;
use App\Models\AlurDana;
use App\Notifications\PembayaranUserBaru;

class CheckoutController extends Controller
{
    private $adminUserId = 1;

    // --- FUNGSI BARU: TERIMA DATA DARI KERANJANG ---
    public function prepareCheckout(Request $request)
    {
        // 1. Validasi: Harus ada barang yang dipilih (array)
        $request->validate([
            'selected_products' => 'required|array',
            'selected_products.*' => 'exists:barangs,id',
        ]);

        // 2. Simpan ID barang yang dipilih ke SESSION SEMENTARA
        session(['checkout_selected_ids' => $request->selected_products]);
        
        // 3. Reset step ke 1
        session(['checkout_step' => 1]); 

        // 4. Redirect ke halaman checkout utama
        return redirect()->route('checkout.index');
    }

    private function getAdminBankAccounts()
    {
        return Rekening::where('user_id', $this->adminUserId)
                       ->where('status_aktif', 'aktif')
                       ->get();
    }

    private function getCartData(int $userId)
    {
        $cart = session('cart', []);
        
        // --- MODIFIKASI: AMBIL FILTER DARI SESSION ---
        $selectedIds = session('checkout_selected_ids', []);

        // Jika tidak ada ID yang dipilih, kembalikan null (agar diredirect balik ke keranjang)
        if (empty($selectedIds)) {
            return null;
        }

        // Filter cart: Hanya ambil item milik User INI dan ID-nya ada di daftar SELECTED
        $userCart = collect($cart)->filter(function($item, $key) use ($userId, $selectedIds) {
            $parts = explode('-', $key);
            $cartUserId = $parts[0];
            $cartProductId = $parts[1] ?? null;

            // Logic: User Cocok DAN Product ID ada di array Selected
            return $cartUserId == $userId && in_array($cartProductId, $selectedIds);
        });

        if ($userCart->isEmpty()) return null;

        $itemsQty = [];
        $productIds = [];
        foreach ($userCart as $key => $data) {
            $productId = explode('-', $key)[1];
            $productIds[] = $productId;
            $itemsQty[$productId] = $data['qty'];
        }

        $produks = Barang::whereIn('id', $productIds)->with('jastiper')->get()->keyBy('id');

        $cartDetails = [];
        $subtotal = 0;
        $totalBerat = 0;

        foreach ($itemsQty as $productId => $qty) {
            $produk = $produks->get($productId);
            if ($produk) {
                $totalHargaItem = $produk->harga * $qty;
                $subtotal += $totalHargaItem;
                $totalBerat += ($produk->berat_gr ?? 1) * $qty;

                $cartDetails[] = (object)[
                    'produk' => $produk,
                    'qty' => $qty,
                    'total_harga' => $totalHargaItem,
                ];
            }
        }

        return (object)[
            'cartDetails' => $cartDetails,
            'subtotal' => $subtotal,
            'totalBerat' => $totalBerat,
            'total_final' => $subtotal,
        ];
    }

    private function clearUserCartFromSession($userId)
    {
        $cart = session('cart', []);
        
        // --- MODIFIKASI: HAPUS HANYA YANG DIPILIH (DIBAYAR) ---
        $selectedIds = session('checkout_selected_ids', []);

        foreach ($selectedIds as $productId) {
            $key = $userId . '-' . $productId;
            if (isset($cart[$key])) {
                unset($cart[$key]);
            }
        }

        // Simpan sisa keranjang
        session(['cart' => $cart]);
        
        // Bersihkan session temporary selected IDs
        session()->forget('checkout_selected_ids');
    }

    private function createOrderAndStoreIdInSession($cartDetails, $totalFinal, $alamatData, $userId, $paymentType, $bank = null)
    {
        DB::beginTransaction();
        try {
            $alamatFull = $alamatData['alamat_lengkap'] . ', ' .
                $alamatData['kota'] . ', ' .
                $alamatData['provinsi'] . ' (' .
                $alamatData['kode_pos'] . ')';

            $groupedByJastiper = collect($cartDetails)
                ->groupBy(fn ($item) => $item->produk->jastiper_id);

            $pesananIds = [];

            foreach ($groupedByJastiper as $jastiperId => $items) {

                $total = $items->sum(fn ($i) => $i->total_harga);

                $pesanan = Pesanan::create([
                    'user_id' => $userId,
                    'jastiper_id' => $jastiperId,
                    'total_harga' => $total,
                    'alamat_pengiriman' => $alamatFull,
                    'catatan' => $alamatData['catatan'] ?? null,
                    'status_pesanan' => 'MENUNGGU_PEMBAYARAN',
                    'status_dana_jastiper' => 'TERTAHAN',
                    'no_hp' => Auth::user()->no_hp ?? null,
                ]);

                foreach ($items as $item) {
                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'barang_id' => $item->produk->id,
                        'jumlah' => $item->qty,
                        'subtotal' => $item->total_harga,
                    ]);
                }

                $pesananIds[] = $pesanan->id;
            }

            DB::commit();

            // Kirim Notifikasi FCM ke Jastiper
            foreach ($groupedByJastiper as $jastiperId => $items) {
                $jastiper = \App\Models\Jastiper::find($jastiperId);
                if ($jastiper && $jastiper->user && $jastiper->user->fcm_token) {
                    try {
                        \App\Services\FcmService::send(
                            $jastiper->user->fcm_token,
                            "Pesanan Baru Masuk!",
                            "Ada pembeli yang baru saja melakukan checkout barang Anda. Menunggu pembayaran.",
                            ['type' => 'PESANAN_BARU']
                        );
                    } catch (\Exception $e) {}
                }
            }

            // Setup Midtrans CoreApi
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $invoiceNumber = 'JST-' . time() . '-' . rand(100, 999);
            $user = Auth::user();

            $params = [
                'payment_type' => $paymentType,
                'transaction_details' => [
                    'order_id' => $invoiceNumber,
                    'gross_amount' => $totalFinal,
                ],
                'customer_details' => [
                    'first_name' => $user->nama_lengkap ?? $user->name,
                    'email' => $user->email,
                    'phone' => $user->no_hp ?? '',
                ],
            ];

            if ($paymentType == 'bank_transfer') {
                $params['bank_transfer'] = ['bank' => $bank];
            }

            $charge = \Midtrans\CoreApi::charge($params);

            $vaNumber = null;
            $qrUrl = null;
            $deeplink = null;

            if (isset($charge->va_numbers) && count($charge->va_numbers) > 0) {
                $vaNumber = $charge->va_numbers[0]->va_number;
            } elseif (isset($charge->biller_code) && isset($charge->bill_key)) {
                $vaNumber = $charge->biller_code . '-' . $charge->bill_key;
            } elseif (isset($charge->actions)) {
                foreach ($charge->actions as $action) {
                    if ($action->name === 'generate-qr-code') {
                        $qrUrl = $action->url;
                    } elseif ($action->name === 'deeplink-redirect') {
                        $deeplink = $action->url;
                    }
                }
            }

            $paymentInfo = $vaNumber ?? $qrUrl ?? $deeplink ?? $charge->transaction_id ?? '';

            Pesanan::whereIn('id', $pesananIds)->update([
                'snap_token' => $paymentInfo, // Kita gunakan kolom snap_token untuk menyimpan VA/Link
                'invoice_number' => $invoiceNumber
            ]);

            session(['current_pesanan_ids' => $pesananIds]);
            session(['current_payment_info' => $paymentInfo]);
            session(['current_payment_type' => $paymentType]);
            session(['current_payment_bank' => $bank]);

            return $pesananIds;

        } catch (\Exception $e) {
            // JIKA MIDTRANS MENOLAK KARENA BELUM DIAKTIVASI (402), KITA BERIKAN DUMMY DATA AGAR UI BISA DITEST!
            if (str_contains($e->getMessage(), '402') || str_contains($e->getMessage(), 'Payment channel is not activated')) {
                $dummyVa = '8077' . rand(1000000, 9999999);
                $dummyQr = 'https://api.sandbox.midtrans.com/v2/qris/dummy-qr-code';
                
                $vaNumber = (str_contains($paymentType, 'bank_transfer') || $paymentType == 'echannel') ? $dummyVa : null;
                $qrUrl = ($paymentType == 'qris') ? $dummyQr : null;
                $deeplink = ($paymentType == 'gopay' || $paymentType == 'shopeepay') ? 'https://gopay.co.id/dummy' : null;

                $paymentInfo = $vaNumber ?? $qrUrl ?? $deeplink ?? 'DUMMY-' . $dummyVa;

                Pesanan::whereIn('id', $pesananIds)->update([
                    'snap_token' => $paymentInfo,
                    'invoice_number' => $invoiceNumber ?? ('JST-' . time())
                ]);

                session(['current_pesanan_ids' => $pesananIds]);
                session(['current_payment_info' => $paymentInfo]);
                session(['current_payment_type' => $paymentType]);
                session(['current_payment_bank' => $bank]);

                return $pesananIds;
            }

            // Jika error lain, throw
            throw $e;
        }
    }


    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan checkout.');
        }

        $userId = Auth::id();

        // JIKA RESUME PEMBAYARAN DARI RIWAYAT
        if ($request->has('pesanan_id')) {
            $pesananId = $request->query('pesanan_id');
            $pesanan = Pesanan::where('id', $pesananId)->where('user_id', $userId)->with('detailPesanans.barang.jastiper')->first();
            
            if (!$pesanan || $pesanan->status_pesanan !== 'MENUNGGU_PEMBAYARAN') {
                return redirect()->route('pesanan.riwayat')->with('error', 'Pesanan tidak dapat dibayar atau tidak ditemukan.');
            }

            $cartDetails = [];
            $totalBerat = 0;
            foreach ($pesanan->detailPesanans as $detail) {
                $cartDetails[] = (object)[
                    'produk' => $detail->barang,
                    'qty' => $detail->jumlah,
                    'total_harga' => $detail->subtotal,
                ];
                $totalBerat += ($detail->barang->berat_gr ?? 1) * $detail->jumlah;
            }

            session(['checkout_step' => 3]);
            session(['current_pesanan_ids' => [$pesanan->id]]);
            session(['checkout_address' => [
                'alamat_lengkap' => $pesanan->alamat_pengiriman,
                'provinsi' => '-',
                'kota' => '-',
                'kode_pos' => '-',
                'catatan' => $pesanan->catatan
            ]]);

            $step = 3;
            $subtotal = $pesanan->total_harga;
            $total_final = $pesanan->total_harga;
            $cartCount = count(session('cart', []));
            $rekeningAdmin = $this->getAdminBankAccounts();
            
            $paymentInfo = $pesanan->snap_token;
            $paymentType = null;
            $paymentBank = null;

            return view('user.checkout.index', compact(
                'cartDetails', 'subtotal', 'totalBerat', 'total_final',
                'step', 'rekeningAdmin', 'cartCount', 'paymentInfo', 'paymentType', 'paymentBank'
            ));
        }

        // --- NORMAL CHECKOUT DARI KERANJANG ---
        if (!session()->has('checkout_selected_ids') && !session('current_pesanan_ids')) {
             return redirect()->route('keranjang.index')->with('error', 'Silakan pilih barang yang ingin dibeli terlebih dahulu.');
        }

        $cartData = $this->getCartData($userId);
        $pesananIds = session('current_pesanan_ids', []);
        
        $step = session('checkout_step', 1);

        if (empty($pesananIds) && $step > 3 && $cartData) {
            $step = 1;
            session(['checkout_step' => 1]);
        }
 
        $cartDetails = $cartData?->cartDetails ?? [];
        $subtotal     = $cartData?->subtotal ?? 0;
        $totalBerat   = $cartData?->totalBerat ?? 0;
        $total_final  = $cartData?->total_final ?? 0;

        $rekeningAdmin = $this->getAdminBankAccounts();

        if (!empty($pesananIds)) {
            $total_final = Pesanan::whereIn('id', $pesananIds)->sum('total_harga');
        }
        $cartCount = count(session('cart', []));

        $paymentInfo = session('current_payment_info');
        $paymentType = session('current_payment_type');
        $paymentBank = session('current_payment_bank');

        return view('user.checkout.index', compact(
            'cartDetails', 'subtotal', 'totalBerat', 'total_final',
            'step', 'rekeningAdmin', 'cartCount', 'paymentInfo', 'paymentType', 'paymentBank'
        ));
    }

    public function processStep(Request $request)
    {
        if (!Auth::check()) { return redirect()->route('login'); }
        
        $userId = Auth::id();
        $currentStep = (int) $request->input('current_step');
        $nextStep = $currentStep + 1;

        // PROSES DARI STEP 1 KE 2
        if ($currentStep == 1) { 
            session(['checkout_step' => $nextStep]);
            return redirect()->route('checkout.index');
        } 
        
        // PROSES DARI STEP 2 KE 3 (Simpan Alamat Saja)
        else if ($currentStep == 2) { 
            $request->validate([
                'alamat_lengkap' => 'required|string|min:10',
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'kode_pos' => 'required|numeric',
                'catatan' => 'nullable|string|max:255',
            ]);
            
            $alamatData = $request->only(['alamat_lengkap', 'provinsi', 'kota', 'kode_pos', 'catatan']);
            session(['checkout_address' => $alamatData]);
            session(['checkout_step' => $nextStep]);
            return redirect()->route('checkout.index');
        }
        
        // PROSES DARI STEP 3 KE 4 (Create Order & Panggil Midtrans CoreApi)
        else if ($currentStep == 3) { 
            $request->validate([
                'payment_method' => 'required|string',
            ]);

            $method = $request->input('payment_method'); // e.g. bank_transfer_bca, gopay, qris
            $parts = explode('_', $method);
            $paymentType = $parts[0]; // bank or gopay
            $bank = null;

            if ($paymentType == 'bank' && isset($parts[1]) && $parts[1] == 'transfer') {
                $paymentType = 'bank_transfer';
                $bank = $parts[2] ?? null; // bca, bni, bri, etc.
            }

            // CEK APAKAH RESUME ORDER DARI RIWAYAT
            $pesananIds = session('current_pesanan_ids', []);
            if (!empty($pesananIds)) {
                try {
                    $this->updateMidtransPayment($pesananIds, $paymentType, $bank);
                    session(['checkout_step' => $nextStep]);
                    return redirect()->route('checkout.index');
                } catch (\Exception $e) {
                    return back()->with('error', 'Gagal memperbarui metode pembayaran: ' . $e->getMessage());
                }
            }

            // JIKA BUKAN RESUME ORDER (ORDER BARU)
            $alamatData = session('checkout_address');
            if (!$alamatData) { return redirect()->route('checkout.index')->with('error', 'Alamat belum diisi.'); }

            $cartData = $this->getCartData($userId);
            if (!$cartData) { return redirect()->route('keranjang.index')->with('error', 'Keranjang kosong saat checkout.'); }

            try {
                $this->createOrderAndStoreIdInSession($cartData->cartDetails, $cartData->total_final, $alamatData, $userId, $paymentType, $bank);
                
                $this->clearUserCartFromSession($userId);
                session(['checkout_step' => $nextStep]);

                return redirect()->route('checkout.index');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('checkout.index');
    }

    private function updateMidtransPayment($pesananIds, $paymentType, $bank)
    {
        $pesanans = Pesanan::whereIn('id', $pesananIds)->get();
        if ($pesanans->isEmpty()) throw new \Exception('Pesanan tidak ditemukan');

        $totalFinal = $pesanans->sum('total_harga');
        $user = Auth::user();

        // Setup Midtrans CoreApi
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $invoiceNumber = 'UPDATE-' . time() . '-' . $pesanans->first()->id;

        $params = [
            'payment_type' => $paymentType,
            'transaction_details' => [
                'order_id' => $invoiceNumber,
                'gross_amount' => $totalFinal,
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap ?? $user->name,
                'email' => $user->email,
                'phone' => $user->no_hp ?? '',
            ],
        ];

        if ($paymentType == 'bank_transfer') {
            $params['bank_transfer'] = ['bank' => $bank];
        }

        try {
            $charge = \Midtrans\CoreApi::charge($params);

            $vaNumber = null;
            $qrUrl = null;
            $deeplink = null;

            if (isset($charge->va_numbers) && count($charge->va_numbers) > 0) {
                $vaNumber = $charge->va_numbers[0]->va_number;
            } elseif (isset($charge->biller_code) && isset($charge->bill_key)) {
                $vaNumber = $charge->biller_code . '-' . $charge->bill_key;
            } elseif (isset($charge->actions)) {
                foreach ($charge->actions as $action) {
                    if ($action->name === 'generate-qr-code') $qrUrl = $action->url;
                    elseif ($action->name === 'deeplink-redirect') $deeplink = $action->url;
                }
            }

            $paymentInfo = $vaNumber ?? $qrUrl ?? $deeplink ?? $charge->transaction_id ?? '';

            Pesanan::whereIn('id', $pesananIds)->update([
                'snap_token' => $paymentInfo
            ]);

            session(['current_payment_info' => $paymentInfo]);
            session(['current_payment_type' => $paymentType]);
            session(['current_payment_bank' => $bank]);

        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), '402') || str_contains($e->getMessage(), 'Payment channel is not activated')) {
                $dummyVa = '8077' . rand(1000000, 9999999);
                $dummyQr = 'https://api.sandbox.midtrans.com/v2/qris/dummy-qr-code';
                
                $vaNumber = (str_contains($paymentType, 'bank_transfer') || $paymentType == 'echannel') ? $dummyVa : null;
                $qrUrl = ($paymentType == 'qris') ? $dummyQr : null;
                $deeplink = ($paymentType == 'gopay' || $paymentType == 'shopeepay') ? 'https://gopay.co.id/dummy' : null;

                $paymentInfo = $vaNumber ?? $qrUrl ?? $deeplink ?? 'DUMMY-' . $dummyVa;

                Pesanan::whereIn('id', $pesananIds)->update([
                    'snap_token' => $paymentInfo
                ]);

                session(['current_payment_info' => $paymentInfo]);
                session(['current_payment_type' => $paymentType]);
                session(['current_payment_bank' => $bank]);
            } else {
                throw $e;
            }
        }
    }
    
    public function finalizeCheckout()
    {
        session()->forget('current_pesanan_ids');
        session()->forget('current_snap_token');
        session()->forget('current_payment_info');
        session()->forget('current_payment_type');
        session()->forget('current_payment_bank');
        session()->forget('checkout_step');
        session()->forget('checkout_address');
        session()->forget('checkout_selected_ids');
        
        return view('user.checkout.success');
    }

    public function previousStep()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $currentStep = session('checkout_step', 1);
        $previousStep = max(1, $currentStep - 1);
        
        session(['checkout_step' => $previousStep]);

        return redirect()->route('checkout.index');
    }

    public function simulatePayment(Request $request)
    {
        $pesananIds = session('current_pesanan_ids', []);
        
        if (empty($pesananIds)) {
            return back()->with('error', 'Tidak ada pesanan aktif untuk disimulasikan.');
        }

        DB::beginTransaction();
        try {
            $pesanans = Pesanan::whereIn('id', $pesananIds)->with('detailPesanans')->get();
            
            foreach ($pesanans as $pesanan) {
                // Potong stok
                foreach ($pesanan->detailPesanans as $detail) { 
                    $barang = Barang::lockForUpdate()->find($detail->barang_id);
                    if ($barang && $barang->stok >= $detail->jumlah) {
                        $barang->stok -= $detail->jumlah;
                        $barang->save();
                    }
                }

                $pesanan->update([
                    'status_pesanan' => 'DIPROSES',
                    'status_dana_jastiper' => 'TERTAHAN'
                ]);
                
                // Catat ke Alur Dana
                \App\Models\AlurDana::create([
                    'pesanan_id'        => $pesanan->id,
                    'jenis_transaksi'   => 'PEMBAYARAN_USER',
                    'jumlah_dana'       => $pesanan->total_harga,
                    'bukti_tf_path'     => 'MIDTRANS_SIMULASI',
                    'status_konfirmasi' => 'DIKONFIRMASI',
                    'konfirmator_id'    => null,
                    'tanggal_transfer'  => now(),
                ]);

                // Kirim notifikasi ke Admin
                $admins = \App\Models\User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new \App\Notifications\PembayaranUserBaru($pesanan));
                }
            }

            DB::commit();
            
            // Langsung finish
            return $this->finalizeCheckout()->with('success', 'Simulasi Pembayaran Berhasil! Pesanan sekarang diteruskan ke Jastiper.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mensimulasikan pembayaran: ' . $e->getMessage());
        }
    }
}