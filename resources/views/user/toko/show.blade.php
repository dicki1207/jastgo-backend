@php
    $userIsLoggedIn = Auth::check();
    $userName = $userIsLoggedIn ? Auth::user()->name ?? 'Pengguna' : 'Guest';
    $cartCount = count(session('cart', []));

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        
        /* Store Hero Section */
        .store-hero {
            position: relative;
            margin-top: 2rem;
            margin-bottom: 3rem;
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .store-banner {
            height: 200px;
            background: linear-gradient(135deg, #006FFF 0%, #6fa8ff 100%);
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            position: relative;
            overflow: hidden;
        }
        .store-banner::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.3;
        }
        .store-profile-wrapper {
            display: flex;
            align-items: flex-end;
            padding: 0 2rem 2rem 2rem;
            margin-top: -60px;
            position: relative;
            z-index: 10;
            gap: 2rem;
        }
        .store-avatar {
            width: 140px; height: 140px; border-radius: 50%;
            border: 6px solid white; background: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; flex-shrink: 0;
        }
        .store-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .store-avatar i { font-size: 4rem; color: #006FFF; }
        
        .store-info { flex-grow: 1; padding-bottom: 0.5rem; align-self: flex-end; margin-bottom: 1rem; }
        .store-name { font-size: 2rem; font-weight: 800; color: #1f2937; margin-bottom: 0.4rem; }
        .store-meta { font-size: 0.95rem; color: #6b7280; display: flex; align-items: center; gap: 1rem; margin-bottom: 0.6rem; }
        
        .store-stats-inline {
            display: flex; gap: 1.5rem; font-size: 0.95rem; color: #4b5563;
        }
        .store-stats-inline span { display: flex; align-items: center; gap: 6px; }
        .store-stats-inline strong { color: #1f2937; font-size: 1.05rem; }
        
        .store-actions { display: flex; gap: 0.8rem; align-items: center; padding-bottom: 1.5rem; }
        
        .btn-chat {
            background: #FFDD00; color: #111; padding: 0.7rem 1.8rem; border-radius: 50px;
            font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px;
            transition: 0.3s; box-shadow: 0 4px 10px rgba(255, 221, 0, 0.3); font-size: 0.95rem;
        }
        .btn-chat:hover { background: #e6c800; transform: translateY(-2px); color: #111; }
        
        .btn-report-subtle {
            background: transparent; color: #9ca3af; border: none; padding: 0.5rem;
            border-radius: 50%; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
        }
        .btn-report-subtle:hover { color: #dc3545; background: #fff5f5; }

        @media (max-width: 768px) {
            .container { padding: 0 1rem; }
            
            /* Store Hero - Edge to Edge di Mobile */
            .store-hero { 
                margin-top: 0; 
                margin-bottom: 1rem; 
                border-radius: 0; 
                box-shadow: none; 
                border-bottom: 6px solid #e5e7eb; /* Pemisah tebal ala aplikasi */
                margin-left: -1rem; 
                margin-right: -1rem;
            }
            .store-banner { 
                height: 100px; 
                border-radius: 0; 
            }
            .store-profile-wrapper { 
                flex-direction: column; 
                align-items: center; 
                text-align: center; 
                margin-top: -40px; 
                padding: 0 1.2rem 1.2rem 1.2rem; 
                gap: 0; 
            }
            .store-avatar { 
                width: 80px; 
                height: 80px; 
                border-width: 3px; 
                margin-bottom: 0.5rem;
            }
            .store-avatar i { font-size: 2.2rem; }
            
            .store-info { 
                display: flex; 
                flex-direction: column; 
                align-items: center; 
                margin-bottom: 0; 
                width: 100%;
            }
            .store-name { font-size: 1.25rem; margin-bottom: 0.2rem; font-weight: 800; }
            .store-meta { 
                font-size: 0.8rem; 
                color: #6b7280; 
                margin-bottom: 0.8rem; 
            }
            
            /* Stats (Produk & Rating) jadi bentuk Pill/Kotak Rapi */
            .store-stats-inline { 
                font-size: 0.85rem; 
                gap: 1.5rem; 
                justify-content: center; 
                background: #f1f5f9;
                padding: 0.5rem 1.5rem;
                border-radius: 50px;
                margin-bottom: 1.2rem;
                border: none;
                font-weight: 600;
            }
            
            .store-actions { 
                justify-content: center; 
                padding-bottom: 0; 
                width: 100%;
                gap: 0.8rem;
            }
            .btn-chat {
                flex: 1;
                max-width: none;
                justify-content: center;
                padding: 0.7rem;
                font-size: 0.95rem;
                border-radius: 50px;
            }
            .btn-report-subtle {
                background: #f1f5f9;
                padding: 0 1.2rem;
                border-radius: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .section-header { font-size: 1.2rem; margin-bottom: 1rem; }
            
            .product-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.6rem;
                margin-bottom: 2rem;
            }
            .product-card {
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            }
            .product-card img { height: 130px; }
            .product-info { padding: 0.6rem; }
            .product-name { font-size: 0.85rem; min-height: 2.8em; margin-bottom: 0.3rem; }
            .product-price { font-size: 1.05rem; }
            
            .review-item { padding: 1rem; border-radius: 12px; }
        }

        /* Section Titles */
        .section-header {
            font-size: 1.6rem; font-weight: 800; color: #1f2937; margin-bottom: 1.5rem;
            display: flex; align-items: center; gap: 10px; border-left: 5px solid #006FFF; padding-left: 15px;
        }

        /* Product Grid */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 3rem; }
        .product-card {
            background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            text-decoration: none; color: inherit; transition: 0.3s; border: 1px solid #f0f0f0; display: flex; flex-direction: column;
        }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,111,255,0.1); border-color: #C1E0F4; }
        .product-card img { width: 100%; height: 200px; object-fit: contain; background: white; }
        .product-info { padding: 1.2rem; flex-grow: 1; display: flex; flex-direction: column; }
        .product-name { font-weight: 600; margin-bottom: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; color: #374151; min-height: 2.8em;}
        .product-price { font-size: 1.25rem; font-weight: 800; color: #006FFF; margin-top: auto; }

        /* Reviews */
        .review-list { display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 4rem; }
        .review-item {
            background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border: 1px solid #f0f0f0;
        }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 1rem; align-items: center; }
        .review-user { font-weight: 700; color: #1f2937; display: flex; align-items: center; gap: 8px; }
        .review-user i { color: #006FFF; font-size: 1.5rem; }
        .review-date { font-size: 0.85rem; color: #9ca3af; }
        .review-stars { color: #FFDD00; margin-bottom: 1rem; letter-spacing: 2px; }
        .review-text { line-height: 1.6; color: #4b5563; font-size: 0.95rem; }
        .review-photo { margin-top: 1rem; max-width: 120px; border-radius: 8px; border: 2px solid #e5e7eb; cursor: pointer; transition: 0.2s; }
        .review-photo:hover { border-color: #006FFF; }

        .empty-state {
            background: white; border-radius: 16px; padding: 4rem 2rem; text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04); color: #9ca3af; border: 1px solid #f0f0f0; margin-bottom: 3rem;
        }
        .empty-state i { font-size: 4rem; color: #e5e7eb; margin-bottom: 1rem; }

        /* Modal */
        .custom-modal-overlay {
            display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center; backdrop-filter: blur(5px);
        }
        .custom-modal {
            background-color: #fff; margin: auto; padding: 0; border-radius: 16px; width: 90%; max-width: 500px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2); animation: modalFadeIn 0.3s; overflow: hidden;
        }
        .modal-header { padding: 1.5rem; background: #f8fafc; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
        .close-btn { color: #9ca3af; font-size: 24px; cursor: pointer; transition: 0.2s; }
        .close-btn:hover { color: #1f2937; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 1rem; background: #f8fafc;}
        @keyframes modalFadeIn { from {transform: translateY(-20px) scale(0.95); opacity: 0;} to {transform: translateY(0) scale(1); opacity: 1;} }
        
        .form-control { width: 100%; padding: 0.8rem 1rem; border: 2px solid #e5e7eb; border-radius: 10px; font-family: inherit; font-size: 0.95rem; transition: 0.3s; }
        .form-control:focus { outline: none; border-color: #006FFF; }
        .btn { padding: 0.8rem 1.5rem; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; transition: 0.3s; }
        .btn-primary { background: #dc3545; color: white; }
        .btn-primary:hover { background: #b02a37; }
        .btn-outline { background: white; border: 2px solid #e5e7eb; color: #4b5563; }
        .btn-outline:hover { background: #f3f4f6; }
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
    {{-- STORE HERO SECTION --}}
    <div class="store-hero">
        <div class="store-banner"></div>
        <div class="store-profile-wrapper">
            <div class="store-avatar">
                @if($toko->profile_toko)
                    <img src="{{ asset('storage/'.$toko->profile_toko) }}" alt="Logo Toko">
                @elseif($toko->user && $toko->user->avatar)
                    <img src="{{ $toko->user->avatar }}" alt="Avatar User">
                @else
                    <i class="fas fa-store"></i>
                @endif
            </div>
            
            <div class="store-info">
                <h2 class="store-name">{{ $toko->nama_toko }}</h2>
                <div class="store-meta">
                    <span><i class="fas fa-calendar-check"></i> Bergabung {{ $toko->tanggal_daftar?->diffForHumans() ?? '-' }}</span>
                    @if($toko->kota_toko)
                    <span><i class="fas fa-map-marker-alt"></i> {{ $toko->kota_toko }}</span>
                    @endif
                </div>
                <div class="store-stats-inline">
                    <span><i class="fas fa-box" style="color:#006FFF;"></i> <strong>{{ $toko->barangs_count }}</strong> Produk</span>
                    <span><i class="fas fa-star" style="color:#FFDD00;"></i> <strong>{{ number_format($toko->rating ?? 0, 1) }}</strong> Rating</span>
                </div>
            </div>

            <div class="store-actions">
                <a href="{{ route('chat.index') }}" class="btn-chat" title="Mulai Obrolan">
                    <i class="fas fa-comments"></i> Chat
                </a>
                @auth
                <button type="button" class="btn-report-subtle" onclick="openModal()" title="Laporkan Toko ini">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                @endauth
            </div>
        </div>
    </div>

    {{-- CUSTOM MODAL LAPORAN --}}
    <div id="customLaporModal" class="custom-modal-overlay">
      <div class="custom-modal">
        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="terlapor_id" value="{{ $toko->user_id }}">
            
            <div class="modal-header">
              <h3 style="margin:0; font-size:1.2rem; font-weight:700;"><i class="fas fa-exclamation-triangle" style="color:#dc3545; margin-right:8px;"></i> Laporkan Toko</h3>
              <i class="fas fa-times close-btn" onclick="closeModal()"></i>
            </div>
            
            <div class="modal-body">
              <div style="margin-bottom: 1.5rem;">
                  <label style="display:block; margin-bottom:.5rem; font-weight:600; color:#374151;">Alasan Laporan <span style="color:#dc3545;">*</span></label>
                  <textarea name="alasan" rows="4" class="form-control" placeholder="Jelaskan secara detail mengapa Anda melaporkan toko ini (contoh: penipuan, barang palsu, dll)..." required></textarea>
              </div>
              <div>
                  <label style="display:block; margin-bottom:.5rem; font-weight:600; color:#374151;">Bukti Foto <span style="font-weight:400; color:#9ca3af;">(Opsional)</span></label>
                  <input type="file" name="bukti_foto" class="form-control" accept="image/*" style="background:#f9fafb; padding:0.6rem;">
                  <small style="color:#9ca3af; display:block; margin-top:8px;"><i class="fas fa-info-circle"></i> Format: JPG, PNG. Maksimal: 2MB.</small>
              </div>
            </div>
            
            <div class="modal-footer">
              <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
              <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            </div>
        </form>
      </div>
    </div>

    {{-- PRODUK TOKO --}}
    <h3 class="section-header">Produk Unggulan</h3>
    @if($toko->barangs->count() > 0)
        <div class="product-grid">
            @foreach($toko->barangs as $barang)
                <a href="{{ route('produk.detail', $barang->id) }}" class="product-card">
                    <img src="{{ asset('storage/'.$barang->foto_barang) }}" alt="{{ $barang->nama_barang }}">
                    <div class="product-info">
                        <div class="product-name">{{ $barang->nama_barang }}</div>
                        <div class="product-price">Rp {{ number_format($barang->harga, 0, ',', '.') }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h3>Belum Ada Produk</h3>
            <p>Toko ini belum mengunggah produk apapun untuk Jastip.</p>
        </div>
    @endif

    {{-- ULASAN TOKO --}}
    <h3 class="section-header">Penilaian & Ulasan <span style="color:#9ca3af; font-size:1.2rem; font-weight:600; margin-left:5px;">({{ $toko->ulasans->count() }})</span></h3>
    @if($toko->ulasans->count() > 0)
        <div class="review-list">
            @foreach($toko->ulasans as $ulasan)
                <div class="review-item">
                    <div class="review-header">
                        <div class="review-user">
                            <i class="fas fa-user-circle"></i>
                            {{ substr($ulasan->user->name, 0, 1) . str_repeat('*', max(strlen($ulasan->user->name) - 1, 3)) }}
                        </div>
                        <div class="review-date">{{ $ulasan->tanggal_ulasan->diffForHumans() }}</div>
                    </div>
                    <div class="review-stars">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= $ulasan->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star" style="color:#e5e7eb;"></i>
                            @endif
                        @endfor
                    </div>
                    @if($ulasan->komentar)
                        <div class="review-text">
                            {{ $ulasan->komentar }}
                        </div>
                    @endif
                    @if($ulasan->foto_ulasan)
                        <a href="{{ asset('storage/'.$ulasan->foto_ulasan) }}" target="_blank">
                            <img src="{{ asset('storage/'.$ulasan->foto_ulasan) }}" alt="Foto Ulasan" class="review-photo">
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-comment-slash"></i>
            <h3>Belum Ada Ulasan</h3>
            <p>Jadilah yang pertama untuk memberikan ulasan setelah membeli dari toko ini.</p>
        </div>
    @endif

</div>

@include('user.layout.footer')

<script>
function openModal() {
    var modal = document.getElementById("customLaporModal");
    modal.style.display = "flex";
}
function closeModal() {
    var modal = document.getElementById("customLaporModal");
    modal.style.display = "none";
}
window.onclick = function(event) {
    var modal = document.getElementById("customLaporModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
