@php
    use Illuminate\Support\Str;

    // --- LOGIC AUTENTIKASI DAN KERANJANG ---
    $user = Auth::check() ? Auth::user() : (object) ['name' => 'Tamu', 'no_hp' => null];
    $userName = $user->name ?? 'Pengguna';
    $cartCount = count(session('cart', []));

    // Variabel dari Controller: $cartDetails, $subtotal, $totalBerat, $total_final, $step, $pesananId, $rekeningAdmin

    $steps = [
        1 => 'Pemesanan',
        2 => 'Alamat',
        3 => 'Pembayaran',
        4 => 'Konfirmasi',
    ];

    // Ambil data alamat dari sesi untuk Step 2
    $alamatLama = session('checkout_address', [
        'alamat_lengkap' => '',
        'provinsi' => '',
        'kota' => '',
        'kode_pos' => '',
        'catatan' => '',
    ]);

    $userIsLoggedIn = Auth::check();
    $userName = Auth::user()->name ?? 'Pengguna';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Checkout - {{ $steps[$step] ?? 'Pemesanan' }} - JASTGO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ================================================= */
        /* BASE & HEADER STYLES */
        /* ================================================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f7f7;
            color: #333;
        }

        .text-right {
            text-align: right;
        }

        .text-blue {
            color: #006FFF;
        }

        .font-bold {
            font-weight: 700;
        }

        /* ================================================= */
        /* CHECKOUT LAYOUT */
        /* ================================================= */
        .checkout-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            min-height: auto;
        }

        .main-content {
            width: 100%;
            padding: 2rem;
            min-height: auto;
        }

        /* --- Step Header --- */
        .step-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            text-align: center;
            opacity: 0.5;
            position: relative;
        }

        .step-item.active {
            opacity: 1;
            font-weight: bold;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ddd;
            color: #777;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 10;
        }

        .step-item.active .step-icon {
            background: #006FFF;
            color: white;
        }

        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: #ddd;
            z-index: 5;
            transform: translateX(20px);
        }

        /* --- Order Card & Form Styling --- */
        .order-item-card {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            background: #fff;
        }

        .item-checkout-image {
            width: 100px;
            height: 100px;
            flex-shrink: 0;
            border-radius: 8px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .item-checkout-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-checkout-details .name {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .item-checkout-details .price-info {
            color: #006FFF;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        /* File Upload */
        .file-upload-wrapper {
            border: 2px dashed #006FFF;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            background: #f0f8ff;
            position: relative;
            overflow: hidden;
        }

        .file-upload-wrapper input[type="file"] {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            cursor: pointer;
        }

        .file-upload-wrapper span {
            display: block;
            color: #006FFF;
            font-weight: 600;
        }

        /* === Button Styles === */
        .btn-base {
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1rem;
            display: inline-block;
            text-decoration: none !important;
            text-align: center;
        }

        .btn-next {
            background: #FFDD00;
            color: #333;
        }
        
        .btn-primary-blue {
            background: #006FFF;
            color: white;
        }
        
        .btn-back,
        .btn-next,
        .btn-primary-blue {
             padding: 0.8rem 2rem; 
             border: none; 
             border-radius: 50px; 
             font-weight: 700; 
             cursor: pointer; 
             margin-top: 1rem;
             text-decoration: none !important;
             display: inline-block;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
     @include('user.layout.header', [
         'isLoggedIn' => $userIsLoggedIn,
         'cartCount' => $cartCount,
         'searchValue' => '',
         'userName' => $userName,
     ])

    {{-- Main Checkout Area --}}
    <div class="checkout-container">

        <div class="main-content">
            <h1 style="color: #006FFF; font-size: 2rem;">Proses Checkout</h1>

            {{-- Alur Langkah --}}
            <div class="step-header">
                <div class="step-item {{ $step == 1 ? 'active' : '' }}">
                    <div class="step-icon"><i class="fas fa-shopping-cart"></i></div>
                    Pemesanan
                </div>
                <div class="step-item {{ $step == 2 ? 'active' : '' }}">
                    <div class="step-icon"><i class="fas fa-map-marker-alt"></i></div>
                    Alamat
                </div>
                <div class="step-item {{ $step == 3 ? 'active' : '' }}">
                    <div class="step-icon"><i class="fas fa-credit-card"></i></div>
                    Pembayaran
                </div>
                <div class="step-item {{ $step == 4 ? 'active' : '' }}">
                    <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                    Konfirmasi
                </div>
            </div>

            {{-- Tampilkan pesan error/success --}}
            @if (session('success'))
                <div style="background: #e6ffed; color: #1f7a22; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div style="background: #ffe6e6; color: #cc0000; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- CONTENT PER STEP --}}

            @if ($step == 1)
                {{-- STEP 1: PEMESANAN (ORDER SUMMARY) --}}
                <h2 style="margin-bottom: 1.5rem;">Ringkasan Pesanan</h2>
                <p>Silakan tinjau kembali daftar produk yang akan dibeli.</p>

                @foreach ($cartDetails as $item)
                    <div class="order-item-card">
                        <div class="item-checkout-image">
                            @if ($item->produk->foto_barang)
                                <img src="{{ asset('storage/' . $item->produk->foto_barang) }}"
                                    alt="{{ $item->produk->nama_barang }}">
                            @else
                                <i class="fas fa-box"
                                    style="font-size: 3rem; color: rgba(0,0,0,0.1); padding: 1rem;"></i>
                            @endif
                        </div>
                        <div class="item-checkout-details">
                            <div class="name">{{ $item->produk->nama_barang }}</div>
                            <div class="price-info">
                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }} / item
                            </div>
                            <div class="item-store" style="color: #4b5563;">Jastiper:
                                {{ $item->produk->jastiper->nama_toko ?? 'N/A' }}</div>
                        </div>
                        <div class="text-right font-bold text-blue">x{{ $item->qty }}</div>
                    </div>
                @endforeach

                <div style="padding: 1.5rem; border: 1px solid #eee; border-radius: 12px; background: #fafafa; margin-top: 2rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span>Subtotal Harga Barang</span>
                        <span class="font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; border-top: 1px solid #eee; padding-top: 0.5rem;">
                        <span class="font-bold text-blue">TOTAL PESANAN</span>
                        <span class="font-bold text-blue">Rp {{ number_format($total_final, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="text-right">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="current_step" value="1">
                        <button type="submit" class="btn-next btn-base">Selanjutnya</button>
                    </form>
                </div>

            @elseif ($step == 2)
                {{-- STEP 2: ALAMAT & CATATAN --}}
                <h2 style="margin-bottom: 1.5rem;">Informasi Pengiriman</h2>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="current_step" value="2">

                    <div class="form-group">
                        <label for="alamat_lengkap">Alamat Lengkap (Jalan, Nomor Rumah)</label>
                        <textarea id="alamat_lengkap" name="alamat_lengkap" rows="3" required>{{ old('alamat_lengkap', $alamatLama['alamat_lengkap']) }}</textarea>
                    </div>

                    <div style="display: flex; gap: 1.5rem;">
                        <div class="form-group" style="flex: 1;">
                            <label for="provinsi">Provinsi</label>
                            <input type="text" id="provinsi" name="provinsi"
                                value="{{ old('provinsi', $alamatLama['provinsi']) }}" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label for="kota">Kota/Kabupaten</label>
                            <input type="text" id="kota" name="kota"
                                value="{{ old('kota', $alamatLama['kota']) }}" required>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1.5rem;">
                        <div class="form-group" style="flex: 1;">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="text" id="kode_pos" name="kode_pos"
                                value="{{ old('kode_pos', $alamatLama['kode_pos']) }}" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                             {{-- Spacer --}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan Pesanan (Opsional)</label>
                        <textarea id="catatan" name="catatan" rows="2" placeholder="">{{ old('catatan', $alamatLama['catatan'] ?? '') }}</textarea>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('checkout.previous') }}" class="btn-back btn-base">Kembali</a>
                        <button type="submit" class="btn-next btn-base">Selanjutnya</button>
                    </div>
                </form>

            @elseif ($step == 3)
                {{-- STEP 3: PILIH METODE PEMBAYARAN (CORE API) --}}
                <h2 style="margin-bottom: 1.5rem;">Pilih Metode Pembayaran</h2>

                <div style="padding: 1.5rem; border: 2px solid #006FFF; border-radius: 12px; background: #e0f0ff; margin-bottom: 2rem;">
                    <h3 style="color: #006FFF; margin-top: 0;">Total yang Harus Dibayar:</h3>
                    <p style="font-size: 2rem; font-weight: 700; margin: 0;">Rp
                        {{ number_format($total_final, 0, ',', '.') }}</p>
                    <p style="font-size: 0.9rem; color: #4b5563; margin-top: 0.5rem;">Pilih metode pembayaran yang Anda inginkan di bawah ini.</p>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="current_step" value="3">

                    <style>
                        /* Accordion Styles */
                        .payment-accordion {
                            margin-bottom: 2rem;
                            border-radius: 12px;
                            overflow: hidden;
                            border: 1px solid #ddd;
                        }
                        
                        .payment-group {
                            border-bottom: 1px solid #eee;
                        }
                        .payment-group:last-child {
                            border-bottom: none;
                        }
                        
                        .payment-group-header {
                            background: #f8f9fa;
                            padding: 1rem 1.5rem;
                            cursor: pointer;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            font-weight: bold;
                            font-size: 1.1rem;
                            color: #333;
                            transition: background 0.3s;
                        }
                        .payment-group-header:hover {
                            background: #f1f3f5;
                        }
                        
                        .payment-group-content {
                            display: none;
                            padding: 1.5rem;
                            background: white;
                        }
                        .payment-group.active .payment-group-content {
                            display: block;
                        }
                        .payment-group.active .payment-group-header .toggle-icon {
                            transform: rotate(180deg);
                        }
                        
                        .toggle-icon {
                            transition: transform 0.3s;
                        }
                        
                        .payment-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                            gap: 1rem;
                        }
                        
                        .payment-method-card {
                            border: 1px solid #ccc;
                            border-radius: 8px;
                            padding: 1rem;
                            cursor: pointer;
                            display: flex;
                            align-items: center;
                            gap: 1rem;
                            transition: all 0.2s;
                        }
                        .payment-method-card:hover {
                            border-color: #006FFF;
                            background: #f0f8ff;
                        }
                        .payment-method-card input[type="radio"] {
                            accent-color: #006FFF;
                            width: 18px;
                            height: 18px;
                        }
                        .payment-method-card img {
                            max-width: 60px;
                            max-height: 25px;
                            object-fit: contain;
                        }
                        
                        /* Highlight selected radio card */
                        input[type="radio"]:checked + .method-info {
                            font-weight: bold;
                            color: #006FFF;
                        }
                    </style>

                    <div class="payment-accordion" id="paymentAccordion">
                        <!-- Group 1: Transfer Bank -->
                        <div class="payment-group active">
                            <div class="payment-group-header" onclick="toggleAccordion(this)">
                                <span><i class="fas fa-university text-blue"></i> Transfer Bank (Virtual Account)</span>
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </div>
                            <div class="payment-group-content">
                                <div class="payment-grid">
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="bank_transfer_bca" required>
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA">
                                            <span>BCA</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="bank_transfer_bni">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg" alt="BNI">
                                            <span>BNI</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="bank_transfer_bri">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_2020.svg" alt="BRI">
                                            <span>BRI</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="bank_transfer_echannel">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri">
                                            <span>Mandiri Bill</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="bank_transfer_permata">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/38/PermataBank_logo.svg" alt="Permata">
                                            <span>Permata</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Group 2: E-Wallet & QRIS -->
                        <div class="payment-group">
                            <div class="payment-group-header" onclick="toggleAccordion(this)">
                                <span><i class="fas fa-wallet text-blue"></i> E-Wallet & QRIS</span>
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </div>
                            <div class="payment-group-content">
                                <div class="payment-grid">
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="gopay">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay">
                                            <span>GoPay</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="qris">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Logo_ovo_purple.svg" alt="OVO">
                                            <span>OVO</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="qris">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="DANA">
                                            <span>DANA</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card">
                                        <input type="radio" name="payment_method" value="shopeepay">
                                        <div class="method-info" style="display: flex; flex-direction: column; gap: 5px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg" alt="ShopeePay" style="max-width: 50px;">
                                            <span>ShopeePay</span>
                                        </div>
                                    </label>
                                    <label class="payment-method-card" style="grid-column: 1 / -1; justify-content: center;">
                                        <input type="radio" name="payment_method" value="qris">
                                        <div class="method-info" style="display: flex; align-items: center; gap: 10px;">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS" style="max-height: 35px;">
                                            <span>Scan QRIS (Untuk Semua E-Wallet & M-Banking)</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function toggleAccordion(header) {
                            const group = header.parentElement;
                            const isActive = group.classList.contains('active');
                            
                            // Close all other groups
                            document.querySelectorAll('.payment-group').forEach(g => {
                                g.classList.remove('active');
                            });
                            
                            // Toggle current group
                            if (!isActive) {
                                group.classList.add('active');
                            }
                        }
                    </script>

                    <div class="text-right">
                        <a href="{{ route('checkout.previous') }}" class="btn-back btn-base">Kembali</a>
                        <button type="submit" class="btn-primary-blue btn-base">Bayar Sekarang</button>
                    </div>
                </form>

            @elseif ($step == 4)
                {{-- STEP 4: KONFIRMASI AKHIR / TAMPILKAN VA ATAU QR CODE --}}
                <h2 style="margin-bottom: 1.5rem;">Instruksi Pembayaran</h2>
                
                <div style="text-align: center; padding: 2rem; border: 1px solid #eee; border-radius: 12px; background: #fff;">
                    
                    <p style="font-size: 1.2rem; color: #555; margin-bottom: 1rem;">Silakan lakukan pembayaran sebesar:</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #006FFF; margin-bottom: 2rem;">Rp {{ number_format($total_final, 0, ',', '.') }}</p>

                    @if ($paymentType == 'bank_transfer')
                        <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; display: inline-block; min-width: 300px;">
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.5rem; text-transform: uppercase;">Nomor Virtual Account ({{ strtoupper($paymentBank == 'echannel' ? 'mandiri' : $paymentBank) }})</p>
                            <p style="font-size: 2rem; font-family: monospace; font-weight: bold; letter-spacing: 2px; color: #333; margin-bottom: 1rem;">
                                {{ $paymentInfo }}
                            </p>
                            <button onclick="navigator.clipboard.writeText('{{ $paymentInfo }}'); alert('Nomor VA disalin!');" style="padding: 0.5rem 1rem; background: #e0e0e0; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                <i class="fas fa-copy"></i> Salin Nomor
                            </button>
                        </div>
                        <p style="margin-top: 2rem; color: #666;">Buka aplikasi M-Banking atau ATM Anda, lalu pilih menu Transfer > Virtual Account.</p>

                    @elseif ($paymentType == 'gopay' || $paymentType == 'qris' || $paymentType == 'shopeepay')
                        <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; display: inline-block;">
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem; text-transform: uppercase;">Scan QR Code atau Klik Link ({{ strtoupper($paymentType) }})</p>
                            
                            @if(filter_var($paymentInfo, FILTER_VALIDATE_URL))
                                <!-- Jika berupa URL Deeplink (GoPay/ShopeePay) -->
                                <a href="{{ $paymentInfo }}" target="_blank" style="display: inline-block; background: #00AA5B; color: white; padding: 1rem 2rem; border-radius: 50px; font-weight: bold; text-decoration: none; font-size: 1.2rem;">
                                    Buka Aplikasi {{ strtoupper($paymentType) }}
                                </a>
                            @else
                                <!-- Jika berupa Gambar QR Code -->
                                <img src="{{ $paymentInfo }}" alt="QR Code" style="max-width: 250px; border: 1px solid #ddd; padding: 10px; background: white; border-radius: 10px;">
                            @endif
                        </div>
                        <p style="margin-top: 2rem; color: #666;">Pindai QR Code di atas menggunakan aplikasi E-Wallet pilihan Anda, atau klik tombol jika membukanya di HP.</p>
                    @else
                        <p style="color: red;">Metode pembayaran tidak dikenali atau gagal dimuat.</p>
                    @endif

                    <div style="margin-top: 3rem; border-top: 1px solid #eee; padding-top: 2rem;">
                        <p style="margin-bottom: 1rem; color: #333;">Setelah Anda melakukan pembayaran, status pesanan akan otomatis terupdate.</p>
                        
                        <div style="display: flex; gap: 1rem; justify-content: center; align-items: center; flex-wrap: wrap;">
                            <a href="{{ route('checkout.finish') }}" class="btn-primary-blue btn-base" style="background: #28a745;">Saya Sudah Bayar (Lihat Riwayat)</a>
                            
                            <!-- TOMBOL SIMULASI (DEV ONLY) -->
                            <form action="{{ route('checkout.simulate') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-primary-blue btn-base" style="background: #dc3545;" onclick="return confirm('Simulasi pembayaran ini akan langsung mengubah status menjadi DIPROSES/MENUNGGU JASTIPER. Lanjutkan?')">
                                    <i class="fas fa-magic"></i> Simulasi Pembayaran (Bypass)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            @endif

        </div>
    </div>
</body>
</html>