@if(Auth::check() && Auth::user()->role === 'admin')
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                {{-- Admin only --}}
                <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard.index') }}">
                        <img src="{{ asset('admin/assets/images/icons/dashboard.svg') }}" alt="Dashboard"
                            style="width:20px;margin-right:12px">
                        Dashboard
                    </a>
                </li>

                {{-- MASTER DATA DROPDOWN --}}
                @php
                    $isMasterDataActive = request()->is('admin/pengguna*') || request()->is('admin/jastiper*') || request()->is('admin/kategori*') || request()->is('admin/rekening*');
                @endphp
                <li class="menu-item-has-children dropdown {{ $isMasterDataActive ? 'active show' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ $isMasterDataActive ? 'true' : 'false' }}">
                        <img src="{{ asset('admin/assets/images/icons/data-master.svg') }}" style="width:20px;margin-right:12px" alt="Master Data">
                        Master Data
                    </a>
                    <ul class="sub-menu children dropdown-menu {{ $isMasterDataActive ? 'show' : '' }}">
                        <li class="{{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                            <a href="{{ route('admin.pengguna.index') }}">Data Pengguna</a>
                        </li>
                        <li class="{{ request()->is('admin/jastiper*') ? 'active' : '' }}">
                            <a href="{{ route('admin.jastiper.index') }}">Data Jastiper</a>
                        </li>
                        <li class="{{ request()->is('admin/kategori*') ? 'active' : '' }}">
                            <a href="{{ route('admin.kategori.index') }}">Kategori Barang</a>
                        </li>
                        <li class="{{ request()->is('admin/rekening*') ? 'active' : '' }}">
                            <a href="{{ route('admin.rekening.index') }}">Data Rekening</a>
                        </li>
                    </ul>
                </li>

                {{-- TRANSAKSI & AKTIVITAS DROPDOWN --}}
                @php
                    $isTransaksiActive = request()->is('admin/konfirmasi-pembayaran*') || request()->is('admin/pelepasan-dana*') || request()->is('admin/log-aktivitas*') || request()->is('admin/penarikan-dana*') || request()->is('admin/komplain*') || request()->is('admin/refund*');
                @endphp
                <li class="menu-item-has-children dropdown {{ $isTransaksiActive ? 'active show' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ $isTransaksiActive ? 'true' : 'false' }}">
                        <img src="{{ asset('admin/assets/images/icons/kelola-dana.svg') }}" style="width:20px;margin-right:12px" alt="Transaksi">
                        Transaksi & Aktivitas
                    </a>
                    <ul class="sub-menu children dropdown-menu {{ $isTransaksiActive ? 'show' : '' }}">
                        <li class="{{ request()->is('admin/komplain*') ? 'active' : '' }}">
                            <a href="{{ route('admin.komplain.index') }}">Kelola Komplain</a>
                        </li>
                        <li class="{{ request()->is('admin/penarikan-dana*') ? 'active' : '' }}">
                            <a href="{{ route('admin.penarikan-dana.index') }}">Penarikan Dana</a>
                        </li>
                        <li class="{{ request()->is('admin/refund*') ? 'active' : '' }}">
                            <a href="{{ route('admin.refund.index') }}">Pengembalian Dana</a>
                        </li>
                        <li class="{{ request()->is('admin/log-aktivitas*') ? 'active' : '' }}">
                            <a href="{{ route('admin.log-aktivitas.index') }}">Log Aktivitas</a>
                        </li>
                    </ul>
                </li>

                {{-- LAPORAN & ULASAN DROPDOWN --}}
                @php
                    $isLaporanActive = request()->is('admin/ulasans*') || request()->is('admin/laporan') || request()->is('admin/laporan/*') || request()->is('admin/laporan-keuntungan*');
                @endphp
                <li class="menu-item-has-children dropdown {{ $isLaporanActive ? 'active show' : '' }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ $isLaporanActive ? 'true' : 'false' }}">
                        <img src="{{ asset('admin/assets/images/icons/ulasan.svg') }}" style="width:20px;margin-right:12px" alt="Laporan">
                        Laporan & Ulasan
                    </a>
                    <ul class="sub-menu children dropdown-menu {{ $isLaporanActive ? 'show' : '' }}">
                        <li class="{{ request()->is('admin/ulasans*') ? 'active' : '' }}">
                            <a href="{{ route('admin.ulasans.index') }}">Ulasan Aplikasi</a>
                        </li>
                        <li class="{{ request()->is('admin/laporan') || request()->is('admin/laporan/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.laporan.index') }}">Laporan Pengguna</a>
                        </li>
                        <li class="{{ request()->is('admin/laporan-keuntungan*') ? 'active' : '' }}">
                            <a href="{{ route('admin.laporan.keuntungan') }}">Laporan Keuntungan</a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="{{ request()->is('admin/bantuan*') ? 'active' : '' }}">
                    <a href="{{ url('admin/bantuan') }}">
                        <img src="{{ asset('admin/assets/images/icons/bantuan.svg') }}"
                            style="width:20px;margin-right:12px" alt="Bantuan">
                        Bantuan
                    </a>
                </li> --}}
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0; padding:0;">
                        @csrf
                        <button type="submit" class="sidebar-logout-btn"
                            style="background:none; border:0; padding:10px 18px; width:100%; text-align:left; display:flex; align-items:center; gap:12px; cursor:pointer;">
                            <img src="{{ asset('admin/assets/images/icons/logout.svg') }}" alt="Logout"
                                style="width:20px; height:20px; display:block; object-fit:contain;">
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</aside>
@endif