@php
    use Illuminate\Support\Str;
    $userIsLoggedIn = Auth::check();
    $userName = $userIsLoggedIn ? Auth::user()->name ?? 'Pengguna' : 'Guest';
    $cartCount = count(session('cart', []));
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $barang->nama_barang ?? 'Detail Produk' }} - JASTGO</title>
    {{-- Pastikan FontAwesome dimuat di style.blade.php atau tambahkan CDN di sini jika belum --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @include('user.layout.style')

    <style>
        :root {
            --primary: #006FFF;
            --yellow: #FFDD00;
            --light-blue: #C1E0F4;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .detail-layout {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .product-media {
            flex: 1 1 500px;
        }

        .product-info {
            flex: 1 1 380px;
        }

        .main-image {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 16px;
            background: #f0f0f0;
        }

        .main-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: white;
            border-radius: 16px;
        }

        .box {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }

        .btn {
            padding: 0.9rem 1.8rem;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.2s;
        }

        .btn-full {
            width: 100%;
        }

        .btn-primary {
            background: var(--yellow);
            color: #1f2937;
        }

        .btn-buy {
            background: var(--primary);
            color: white;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .quantity-control button {
            width: 44px;
            height: 44px;
            background: var(--light-blue);
            border: none;
            border-radius: 12px;
            font-size: 1.4rem;
            cursor: pointer;
        }

        #qtyDisplay {
            width: 80px;
            height: 44px;
            text-align: center;
            border: 2px solid var(--light-blue);
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .buttons-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .buttons-group form {
            flex: 1;
            min-width: 280px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            transition: 0.3s;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-6px);
        }

        .product-card .img {
            height: 160px;
            background: #f0f0f0;
            overflow: hidden;
        }

        .product-card .img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: white;
        }

        .product-card .info {
            padding: 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card .name {
            font-weight: 600;
            margin-bottom: auto;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card .price {
            font-size: 1.15rem;
            color: var(--primary);
            font-weight: 700;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem auto;
                padding: 0 1rem;
            }

            .detail-layout {
                flex-direction: column;
                gap: 1rem;
            }

            .buttons-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                padding: 0.8rem 1.2rem;
                font-size: 0.95rem;
            }

            .main-image {
                height: 250px;
                border-radius: 12px;
            }

            .product-info h1 {
                font-size: 1.6rem !important;
                line-height: 1.3;
            }

            .price-text {
                font-size: 1.5rem !important;
            }

            .box {
                padding: 1.2rem;
                border-radius: 12px;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.6rem;
                margin-top: 1.5rem;
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

    <div class="container">
        <a href="{{ route('home') }}"
            style="display:inline-flex;align-items:center;gap:0.5rem;color:var(--primary);text-decoration:none;margin-bottom:1rem;font-weight:500;">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="detail-layout">
            <div class="product-media">
                <div class="main-image" style="position: relative;">
                    @php
                        $fotos = array_filter([$barang->foto_barang, $barang->foto_barang_2, $barang->foto_barang_3]);
                        $fotos = array_values($fotos); // Reindex array
                    @endphp
                    
                    <style>
                        .fade-anim {
                            animation: fadeEffect 0.5s ease-in-out;
                        }
                        @keyframes fadeEffect {
                            from { opacity: 0; }
                            to { opacity: 1; }
                        }
                    </style>

                    @if (count($fotos) > 1)
                        <div class="vanilla-carousel" style="width: 100%; height: 100%; position: relative;">
                            @foreach($fotos as $index => $foto)
                                <img src="{{ asset('storage/' . $foto) }}" class="carousel-slide" style="display: {{ $index === 0 ? 'block' : 'none' }}; width: 100%; height: 100%; object-fit: contain; background: white;" alt="{{ $barang->nama_barang }}">
                            @endforeach
                            
                            <button onclick="changeSlide(-1)" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.3); border: none; color: white; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button onclick="changeSlide(1)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.3); border: none; color: white; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-chevron-right"></i>
                            </button>

                            <div style="position: absolute; bottom: 15px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px;">
                                @foreach($fotos as $index => $foto)
                                    <div class="carousel-dot" onclick="goToSlide({{ $index }})" style="width: 10px; height: 10px; border-radius: 50%; background: {{ $index === 0 ? 'var(--primary)' : 'rgba(0,0,0,0.3)' }}; cursor: pointer; transition: 0.3s;"></div>
                                @endforeach
                            </div>
                        </div>
                        <script>
                            let currentSlide = 0;
                            const slides = document.querySelectorAll('.carousel-slide');
                            const dots = document.querySelectorAll('.carousel-dot');
                            
                            function changeSlide(direction) {
                                let nextSlide = currentSlide + direction;
                                if (nextSlide >= slides.length) nextSlide = 0;
                                if (nextSlide < 0) nextSlide = slides.length - 1;
                                goToSlide(nextSlide);
                            }
                            
                            function goToSlide(index) {
                                slides[currentSlide].style.display = 'none';
                                slides[currentSlide].classList.remove('fade-anim');
                                dots[currentSlide].style.background = 'rgba(0,0,0,0.3)';
                                
                                currentSlide = index;
                                
                                slides[currentSlide].style.display = 'block';
                                // Trigger reflow to restart animation
                                void slides[currentSlide].offsetWidth;
                                slides[currentSlide].classList.add('fade-anim');
                                dots[currentSlide].style.background = 'var(--primary)';
                            }
                        </script>
                    @elseif(count($fotos) === 1)
                        <img src="{{ asset('storage/' . $fotos[0]) }}" alt="{{ $barang->nama_barang }}" style="width: 100%; height: 100%; object-fit: contain; background: white;">
                    @else
                        <div style="height:100%;display:flex;align-items:center;justify-content:center;color:#ddd;font-size:5rem;">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </div>
                
                {{-- Deskripsi Produk dipindah ke bawah gambar --}}
                <div class="box" style="margin-top: 1.5rem;">
                    <h3 style="color:var(--primary);margin-bottom:0.5rem;">Deskripsi Produk</h3>
                    <p style="white-space:pre-wrap;line-height:1.7;color:#444;">
                        {{ $barang->deskripsi ?? 'Deskripsi belum tersedia.' }}
                    </p>
                </div>
            </div>

            <div class="product-info">
                <h1 style="font-size:2.6rem;margin-bottom:0.8rem;">{{ $barang->nama_barang }}</h1>

                <div class="box">
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                        <div
                            style="width:56px;height:56px;border-radius:50%;overflow:hidden;background:#006FFF;display:flex;align-items:center;justify-content:center;">
                            @if ($barang->jastiper && $barang->jastiper->profile_toko)
                                <img src="{{ asset('storage/' . $barang->jastiper->profile_toko) }}"
                                    style="width:100%;height:100%;object-fit:cover;">
                            @elseif ($barang->jastiper && $barang->jastiper->user && $barang->jastiper->user->avatar)
                                <img src="{{ $barang->jastiper->user->avatar }}"
                                    style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <i class="fas fa-store" style="color:white;font-size:1.6rem;"></i>
                            @endif
                        </div>
                        <div>
                            <h3 style="margin:0;font-size:1.4rem;">{{ $barang->jastiper->nama_toko ?? 'Toko Jastip' }}
                            </h3>
                            <div style="color:#facc15;">
                                <i class="fas fa-star"></i> {{ number_format($barang->jastiper->total_rating ?? 0, 1) }}
                                <small
                                    style="color:#666;">({{ number_format($barang->jastiper->total_penilaian ?? 0, 0, ',', '.') }}
                                    penilaian)</small>
                            </div>
                        </div>
                    </div>


                    <a href="{{ route('toko.show', $barang->jastiper->id) }}" class="btn btn-outline"
                        style="margin-top:1rem;">
                        Kunjungi Toko
                    </a>

                    <div style="padding-top:1rem;border-top:1px solid #eee;">
                        <p style="margin:0;font-weight:600;">Harga Barang</p>
                        <p style="margin:0.4rem 0 0;font-size:2rem;font-weight:700;color:#333;">
                            Rp {{ number_format($barang->harga ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="box">
                    <div style="margin-bottom:1rem;">
                        <h4 style="color:var(--primary);margin:0 0 0.5rem 0;">Panduan Belanja</h4>
                        <ol style="margin:0 0 0 1.5rem;color:#555;">
                            <li>Baca Deskripsi Produk</li>
                            <li>Tentukan jumlah barang</li>
                            <li>Klik "Tambah ke Keranjang" atau "Bayar Sekarang"</li>
                        </ol>
                    </div>

                    <p style="color:#666;margin:1rem 0;">
                        Stok tersedia: <strong>{{ number_format($barang->stok ?? 0, 0, ',', '.') }}</strong>
                    </p>

                    <div class="quantity-control">
                        <span style="font-weight:600;">Jumlah</span>
                        <button type="button" onclick="qtyChange(-1)">−</button>
                        <input type="number" id="qtyDisplay" value="1" min="1"
                            max="{{ $barang->stok ?? 1 }}" readonly>
                        <button type="button" onclick="qtyChange(1)">+</button>
                    </div>

                    <div class="buttons-group">
                        <form action="{{ route('keranjang.tambah', $barang->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="qty" id="qtyToCart" value="1">
                            <button type="submit" class="btn btn-primary btn-full">
                                <i class="fas fa-shopping-cart" style="margin-right:8px;"></i> Tambah
                            </button>
                        </form>

                        <form action="{{ route('keranjang.tambah', $barang->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="qty" id="qtyToBuy" value="1">
                            <input type="hidden" name="action" value="buy_now">
                            <button type="submit" class="btn btn-buy btn-full">
                                Bayar Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($produkSerupa->count())
            <section style="margin-top:4rem;">
                <h3 style="font-size:1.8rem;color:var(--primary);margin-bottom:1.5rem;">Produk Serupa</h3>
                <div class="product-grid">
                    @foreach ($produkSerupa as $p)
                        <a href="{{ route('produk.detail', $p->id) }}" class="product-card">
                            <div class="img">
                                @if ($p->foto_barang)
                                    <img src="{{ asset('storage/' . $p->foto_barang) }}" alt="{{ $p->nama_barang }}">
                                @else
                                    <div
                                        style="height:100%;display:flex;align-items:center;justify-content:center;color:#ddd;">
                                        Gambar
                                    </div>
                                @endif
                            </div>
                            <div class="info">
                                <div class="name">{{ Str::limit($p->nama_barang, 50) }}</div>
                                <div class="price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <script>
        const qtyDisplay = document.getElementById('qtyDisplay');
        const qtyToCart = document.getElementById('qtyToCart');
        const qtyToBuy = document.getElementById('qtyToBuy');
        const maxStok = {{ $barang->stok ?? 1 }};

        function qtyChange(delta) {
            let val = parseInt(qtyDisplay.value) || 1;
            let newVal = val + delta;

            if (newVal >= 1 && newVal <= maxStok) {
                qtyDisplay.value = newVal;
                qtyToCart.value = newVal;
                qtyToBuy.value = newVal;
            } else if (newVal > maxStok) {
                alert('Stok maksimal hanya ' + maxStok.toLocaleString('id-ID'));
            }
        }
    </script>
</body>

</html>
