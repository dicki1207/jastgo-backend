@php
    $userIsLoggedIn = Auth::check();
    $userName = $userIsLoggedIn ? Auth::user()->name ?? 'Pengguna' : 'Guest';
    $cartCount = count(session('cart', []));


    // cek apakah user sudah follow toko ini
    $alreadyFollow = auth()->check()
        ? $toko->followers()->where('user_id', auth()->id())->exists()
        : false;

@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $toko->nama_toko }} - JASTGO</title>

    @include('user.layout.style')
</head>
{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* =========================
   GLOBAL
   ========================= */
:root {
    --primary: #006FFF;
    --yellow: #FFDD00;
    --light-blue: #C1E0F4;
    --text-dark: #1f2937;
}

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    background: #f5f7fa;
    color: var(--text-dark);
}

/* =========================
   CONTAINER
   ========================= */
.container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1.5rem;
}

/* =========================
   BOX (CARD)
   ========================= */
.box {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

/* =========================
   BUTTON
   ========================= */
.btn {
    padding: 0.7rem 1.4rem;
    border-radius: 50px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background: var(--yellow);
    color: #111;
}

.btn-outline {
    background: white;
    border: 2px solid var(--primary);
    color: var(--primary);
}

.btn-outline:hover {
    background: var(--primary);
    color: white;
}

/* =========================
   TOKO (JASTIPER)
   ========================= */
.toko-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.toko-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    overflow: hidden;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toko-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.toko-info h2 {
    margin: 0;
    font-size: 1.8rem;
}

.toko-info small {
    color: #777;
}

.toko-meta {
    display: flex;
    gap: 2rem;
    margin-top: 0.8rem;
    font-weight: 500;
    color: #555;
}

/* =========================
   SECTION TITLE
   ========================= */
.section-title {
    margin: 2.5rem 0 1.2rem;
    font-size: 1.6rem;
    font-weight: 700;
}

/* =========================
   PRODUCT GRID
   ========================= */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.5rem;
}

/* =========================
   PRODUCT CARD
   ========================= */
.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    text-decoration: none;
    color: inherit;
    transition: 0.25s;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-6px);
}

.product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    background: #f0f0f0;
}

.product-card .info {
    padding: 1rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-card .info div {
    font-weight: 600;
    margin-bottom: 0.4rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-card .info strong {
    margin-top: auto;
    font-size: 1.1rem;
    color: var(--primary);
}

/* =========================
   RESPONSIVE
   ========================= */
@media (max-width: 768px) {
    .toko-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .toko-meta {
        flex-direction: column;
        gap: 0.4rem;
    }

    .container {
        margin: 1rem auto;
    }
}
</style>



<body>

@include('user.layout.header', [
    'isLoggedIn' => $userIsLoggedIn,
    'cartCount' => $cartCount,
    'searchValue' => '',
    'userName' => $userName,
])

<div class="container">

    {{-- HEADER TOKO --}}
    <div class="box" style="display:flex;gap:1.5rem;align-items:center;">
        <div style="width:80px;height:80px;border-radius:50%;overflow:hidden;background:#eee;">
            @if($toko->profile_toko)
                <img src="{{ asset('storage/'.$toko->profile_toko) }}"
                     style="width:100%;height:100%;object-fit:cover;">
            @else
                <i class="fas fa-store" style="font-size:2rem;"></i>
            @endif
        </div>

        <div>
            <h2>{{ $toko->nama_toko }}</h2>
            <p style="color:#666;">
                Bergabung {{ $toko->tanggal_daftar?->diffForHumans() ?? '-' }}
            </p>
        </div>
    </div>

    {{-- INFO TOKO --}}
    <div class="box" style="margin-top:1.5rem;">
        <p>📦 Produk: <strong>{{ $toko->barangs_count }}</strong></p>
        <p>⭐ Rating: <strong>{{ number_format($toko->rating ?? 0, 1) }}</strong></p>
    </div>

    {{-- PRODUK TOKO --}}
    <h3 style="margin-top:2rem;">Produk dari Toko Ini</h3>

    <div class="product-grid">
        @forelse($toko->barangs as $barang)
            <a href="{{ route('produk.detail', $barang->id) }}" class="product-card">
                <img src="{{ asset('storage/'.$barang->foto_barang) }}">
                <div class="info">
                    <div>{{ $barang->nama_barang }}</div>
                    <strong>Rp {{ number_format($barang->harga) }}</strong>
                </div>
            </a>
        @empty
            <p>Belum ada produk.</p>
        @endforelse
    </div>

</div>

{{-- =============== END CONTENT =============== --}}

{{-- FOOTER --}}
@include('user.layout.footer')

</body>
</html>


</body>
</html>
