@php
    $userIsLoggedIn = Auth::check();
    $userName = Auth::user()->name ?? 'Pengguna';
    $cartCount = session('cart') ? count(session('cart')) : 0;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tata Cara Belanja - JASTGO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .belanja-section {
            background: #f5f7fa;
            padding: 40px 20px 80px;
        }

        .back-link {
            text-align: left;
            margin-bottom: 20px;
            max-width: 850px;
            margin-left: auto;
            margin-right: auto;
        }

        .back-link a {
            color: #006FFF;
            font-weight: 600;
            text-decoration: none;
            font-size: 15px;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-link a:hover {
            color: #0056b3;
            transform: translateX(-3px);
        }

        .belanja-title {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 40px;
            color: #006FFF;
            text-align: center;
        }

        .belanja-steps {
            max-width: 850px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 20px;
        }

        .step-item {
            background: #ffffff;
            padding: 24px;
            border-radius: 16px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border: 1px solid #edf2f7;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .step-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 111, 255, 0.1);
            border-color: #C1E0F4;
        }

        .step-number {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #006FFF, #00A388);
            color: #fff;
            font-weight: 700;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 111, 255, 0.2);
        }

        .step-text h4 {
            margin: 0 0 8px 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: #2d3748;
        }

        .step-text p {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.6;
            color: #718096;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .belanja-steps {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 520px) {
            .step-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

    @include('user.layout.header', [
        'isLoggedIn' => $userIsLoggedIn,
        'cartCount' => $cartCount,
        'searchValue' => '',
        'userName' => $userName,
    ])

    <section class="belanja-section">
        <div class="container">

            <!-- Back Arrow -->
            <div class="back-link">
                <a href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>

            <h2 class="belanja-title">Panduan Belanja JASTGO</h2>

            <div class="belanja-steps">

                <div class="step-item">
                    <div class="step-number">1</div>
                    <div class="step-text">
                        <h4>Cari Produk</h4>
                        <p>Mulailah mencari barang incaranmu lewat kolom pencarian atau filter kategori yang ada.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">2</div>
                    <div class="step-text">
                        <h4>Pilih Cara Membeli</h4>
                        <p>Tambahkan ke keranjang untuk beli nanti, atau tekan tombol Pembayaran untuk *checkout* instan.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">3</div>
                    <div class="step-text">
                        <h4>Keranjang Belanja</h4>
                        <p>Jika lewat keranjang, buka halaman keranjang dan pastikan barang sudah sesuai sebelum bayar.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">4</div>
                    <div class="step-text">
                        <h4>Isi Alamat Pengiriman</h4>
                        <p>Lengkapi alamat dengan detail dan berikan catatan opsional untuk Jastiper jika diperlukan.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">5</div>
                    <div class="step-text">
                        <h4>Pilih Rekening Admin</h4>
                        <p>Pilih bank tujuan (Rekening Resmi JASTGO) dan salin nomor rekening yang tertera.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">6</div>
                    <div class="step-text">
                        <h4>Lakukan Transfer</h4>
                        <p>Transfer tagihan sesuai dengan **Total Belanja** menggunakan *mobile banking* atau ATM.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">7</div>
                    <div class="step-text">
                        <h4>Unggah Bukti Transfer</h4>
                        <p>Unggah struk atau bukti transfer di halaman pesanan lalu tunggu Admin memverifikasinya.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">8</div>
                    <div class="step-text">
                        <h4>Pantau Status</h4>
                        <p>Pesananmu akan berubah status menjadi "Diproses" lalu "Dikirim". Pantau terus di Riwayat!</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">9</div>
                    <div class="step-text">
                        <h4>Pesanan Diterima</h4>
                        <p>Klik tombol **Pesanan Diterima** setelah paket kamu sampai dengan selamat di tujuan.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">10</div>
                    <div class="step-text">
                        <h4>Beri Ulasan & Rating</h4>
                        <p>Beri bintang dan ulasan beserta foto untuk membantu Jastiper mendapatkan reputasi baik!</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">11</div>
                    <div class="step-text">
                        <h4>Jika Pembayaran Gagal</h4>
                        <p>Jangan panik, hubungi Admin melalui tombol WhatsApp. Dana akan dikembalikan sepenuhnya.</p>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-number">12</div>
                    <div class="step-text">
                        <h4>Pusat Bantuan</h4>
                        <p>Jika mengalami kendala teknis atau pesanan bermasalah, segera hubungi kontak sosial media JASTGO.</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    @include('user.layout.footer')

</body>
</html>
