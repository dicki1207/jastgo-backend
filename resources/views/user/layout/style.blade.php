<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- USER FAVICON --}}
<link rel="icon" type="image/png" href="{{ asset('admin/assets/images/logo.png') }}">
<link rel="shortcut icon" href="{{ asset('admin/assets/images/logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('admin/assets/images/logo.png') }}">

{{-- Link Font Awesome untuk Ikon --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Reset & Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        background: #f5f7fa;
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    /* Sembunyikan scrollbar secara global untuk Chrome, Safari, dan Opera */
    ::-webkit-scrollbar {
        display: none;
        width: 0;
        height: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f7fa;
        color: #333;
        padding-bottom: 0;
        overflow-x: hidden;
    }

    @media (max-width: 768px) {
        body {
            padding-bottom: 70px; /* Space for bottom nav */
        }
    }

    /* Header & Navigasi */
    header {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    

    .logo {
        font-size: 1.8rem;
        font-weight: bold;
        color: #006FFF;
    }

    .search-bar {
        flex: 1;
        max-width: 500px;
        position: relative;
    }

    .search-bar input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid #C1E0F4;
        border-radius: 50px;
        font-size: 0.95rem;
        transition: border-color 0.3s;
    }

    .search-bar input:focus {
        outline: none;
        border-color: #006FFF;
    }

    .search-bar i {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #006FFF;
    }

    .header-nav {
        display: flex;
        gap: 1.5rem;
        align-items: center;
    }

    .header-nav a {
        text-decoration: none;
        color: #4b5563;
        font-weight: 500;
        transition: color 0.3s;
    }

    .header-nav a:hover {
        color: #006FFF;
    }

    .login-btn {
        background: #006FFF;
        color: white !important;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        transition: background 0.3s;
    }

    .login-btn:hover {
        background: #0056CC;
    }
    
    /* Cart & Profile Icon Styles */
    .cart-icon { font-size: 1.5rem; color: #4b5563; position: relative; }
    .cart-count { position: absolute; top: -5px; right: -10px; background: red; color: white; border-radius: 50%; padding: 0.1rem 0.4rem; font-size: 0.7rem; line-height: 1; }
    .profile-icon { font-size: 1.5rem; color: #006FFF; }
    .profile-link { display: flex; align-items: center; gap: 0.5rem; color: #006FFF; font-weight: 600; }
    
    /* Global Product Card Styles */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s;
        position: relative;
        border: 2px solid transparent;
        text-decoration: none; 
        color: inherit; 
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 111, 255, 0.15);
        border-color: #C1E0F4;
    }

    .product-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #006FFF 0%, #C1E0F4 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: rgba(255, 255, 255, 0.5);
        overflow: hidden; 
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: white;
    }

    .product-info {
        padding: 1.2rem;
    }

    .store-name {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .store-name i {
        font-size: 0.75rem;
        color: #006FFF;
    }

    .product-name {
        font-size: 1.05rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.8rem;
        min-height: 2.5rem;
        line-height: 1.3;
    }

    .product-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: #006FFF;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #006FFF;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
        color: #C1E0F4;
    }
    
    /* Responsive Header for Mobile */
    @media (max-width: 768px) {
        .header-container {
            padding: 0.8rem 1rem;
            flex-direction: row;
            flex-wrap: nowrap;
        }

        .search-bar {
            order: 2;
            flex: 1;
            max-width: 100%;
            margin-left: 10px;
        }
        
        .search-bar input {
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            font-size: 0.9rem;
        }

        .header-nav {
            display: none !important; /* Hide desktop nav on mobile */
        }
        
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .product-card .img, .product-image {
            height: 140px;
        }
        
        .product-name {
            font-size: 0.9rem;
            min-height: 2.2rem;
            margin-bottom: 0.4rem;
        }
        
        .product-price {
            font-size: 1rem;
        }
    }

    /* =========================================
       MOBILE BOTTOM NAVIGATION
       ========================================= */
    .mobile-bottom-nav {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        z-index: 999;
        padding: 0.5rem 0;
        border-top: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .mobile-bottom-nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        /* Sembunyikan footer Jastgo asli di mobile agar fokus ke bottom nav */
        .jastgo-footer {
            display: none;
        }
    }

    .nav-item-bottom {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #9ca3af;
        font-size: 0.75rem;
        gap: 4px;
        transition: 0.2s;
        width: 25%;
    }

    .nav-item-bottom i {
        font-size: 1.3rem;
        margin-bottom: 2px;
    }

    .nav-item-bottom.active, .nav-item-bottom:hover {
        color: #006FFF;
    }
    
    .nav-item-bottom .badge {
        position: absolute;
        top: -2px;
        right: 25%;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        font-size: 0.6rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .jastgo-footer {
  background: linear-gradient(135deg, #2f6fed, #6fa8ff);
  color: #fff;
  padding: 50px 20px 20px;
  font-family: 'Inter', sans-serif;
}

.footer-container {
  max-width: 1200px;
  margin: auto;
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 30px;
}

.footer-brand h3 {
  font-size: 24px;
  margin-bottom: 10px;
}

.footer-brand p {
  font-size: 14px;
  line-height: 1.6;
  opacity: 0.9;
}

.footer-links h4,
.footer-social h4 {
  margin-bottom: 12px;
  font-size: 16px;
}

.footer-links ul {
  list-style: none;
  padding: 0;
}

.footer-links ul li {
  margin-bottom: 8px;
}

.footer-links ul li a {
  color: #fff;
  text-decoration: none;
  font-size: 14px;
  opacity: 0.9;
}

.footer-links ul li a:hover {
  opacity: 1;
  text-decoration: underline;
}

.social-icons a {
  display: inline-block;
  margin-right: 10px;
  margin-bottom: 6px;
  font-size: 14px;
  color: #ffe066;
  text-decoration: none;
}

.social-icons a:hover {
  text-decoration: underline;
}

.footer-bottom {
  margin-top: 40px;
  padding-top: 15px;
  border-top: 1px solid rgba(255,255,255,0.3);
  text-align: center;
  font-size: 13px;
  opacity: 0.9;
}

/* Responsive */
@media (max-width: 768px) {
  .footer-container {
    grid-template-columns: 1fr;
    text-align: center;
  }

  .social-icons a {
    margin-right: 8px;
  }
}

</style>