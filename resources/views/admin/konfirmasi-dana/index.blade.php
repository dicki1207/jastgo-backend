@extends('layout.admin-app')

@section('title', 'Manajemen Pelepasan Dana - Admin')
@section('page-title', 'Pelepasan Dana Jastiper')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom-user_table.css') }}">
    <style>
        .row-pelepasan-dana>td {
            background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
            border-top: 2px solid #e9ecef !important;
            border-bottom: 2px solid #e9ecef !important;
            padding: 20px 15px !important;
        }

        .pelepasan-container {
            background: white;
            border: 1px solid #e3e6ea;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .pelepasan-title {
            color: #2b6be6;
            font-size: 0.938rem;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pelepasan-form {
            display: flex;
            align-items: flex-end;
            gap: 16px;
        }

        .form-group-custom {
            flex: 1;
            max-width: 500px;
        }

        .form-label-custom {
            font-weight: 600;
            font-size: 0.813rem;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .file-input-custom {
            padding: 10px 14px;
            border: 1px solid #DDE0E3;
            border-radius: 8px;
            width: 100%;
            background: white;
            color: #495057;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .file-input-custom:focus {
            outline: none;
            border-color: #2b6be6;
            box-shadow: 0 0 0 3px rgba(43, 107, 230, 0.1);
        }

        .btn-lepas-dana {
            background: #dc3545;
            color: white;
            min-width: 140px;
            height: 44px;
            border-radius: 8px;
            padding: 0 20px;
            font-weight: 600;
            font-size: 0.813rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-lepas-dana:hover {
            background: #c82333;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .info-subtitle {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .amount-highlight {
            color: #28a745;
            font-weight: 700;
            font-size: 0.938rem;
        }

        .user-info-label {
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .user-info-value {
            color: #212529;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .alert-custom {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid transparent;
        }

        .alert-success-custom {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-danger-custom {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .pelepasan-form {
                flex-direction: column;
                align-items: stretch;
            }

            .form-group-custom {
                max-width: 100%;
            }

            .btn-lepas-dana {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="user-table-card">
        <h2 class="user-table-title">Pelepasan Dana Jastiper</h2>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <form method="GET" action="{{ route('admin.konfirmasi-pembayaran.index') }}"
                style="display:flex; align-items:center; gap:8px;">

                <input name="search" id="searchAction" class="user-search-input" type="text"
                    placeholder="Cari Pesanan (ID/User/Jastiper)" value="{{ $search ?? '' }}"
                    style="padding:8px 12px; border:1px solid #DDE0E3; border-radius:8px; width:320px;">

                <button id="btnSearchJastiper" class="btn-search"
                    style="padding:8px 18px; border-radius:8px; border:1px solid #2b6be6; background:#fff; color:#2b6be6;">
                    Search
                </button>

                <div style="margin-left:8px; color:#6c757d;">
                    Total: <strong>{{ $pesanans->total() ?? $pesanans->count() }}</strong>
                </div>

            </form>
        </div>
        <p class="info-subtitle">
            Daftar ini mencakup semua pesanan yang dananya sedang <strong>TERTAHAN</strong> di sistem (Escrow).<br>
            Pelepasan Dana ke rekening Jastiper hanya bisa dilakukan jika pesanan sudah berstatus <strong>SELESAI</strong>.
        </p>

        @if (session('success'))
            <div class="alert-custom alert-success-custom">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert-custom alert-danger-custom">
                ✕ {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th class="col-id">ID Pesanan</th>
                        <th class="col-name">Info Pesanan</th>
                        <th class="col-name">Rekening Jastiper</th>
                        <th class="col-email">Nominal (Sebelum Potongan)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $pesanan)
                        {{-- BARIS UTAMA PESANAN --}}
                        <tr>
                            <td class="col-id">#{{ $pesanan->id }}</td>
                            <td class="col-name">
                                <div class="mb-1">
                                    <span class="user-info-label">Pembeli:</span>
                                    <span class="user-info-value">{{ $pesanan->user?->name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="user-info-label">Toko Jastip:</span>
                                    <span class="user-info-value">{{ $pesanan->jastiper?->nama_toko ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="col-rekening">
                                @if ($pesanan->jastiper->rekening)
                                    <strong style="font-weight: 600;">{{ $pesanan->jastiper->rekening->nomor_akun }}</strong><br>
                                    {{ ucfirst($pesanan->jastiper->rekening->tipe_rekening) }} -
                                    {{ $pesanan->jastiper->rekening->nama_penyedia }} -
                                    {{ $pesanan->jastiper->rekening->nama_pemilik }}
                                @else
                                    <span class="text-danger">Belum Atur Rekening</span>
                                @endif
                            </td>
                            <td class="col-email">
                                <span class="amount-highlight">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>

                        {{-- BARIS FORM PELEPASAN DANA (ATAU INFO STATUS) --}}
                        <tr class="row-pelepasan-dana">
                            <td colspan="4">
                                @if($pesanan->status_pesanan === 'SELESAI')
                                    <style>
                                        .btn-toggle-pelepasan .fa-chevron-down { transition: transform 0.3s ease; }
                                        .btn-toggle-pelepasan[aria-expanded="true"] .fa-chevron-down { transform: rotate(180deg); }
                                    </style>
                                    <div class="pelepasan-container" style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                        <button class="btn btn-toggle-pelepasan w-100 d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#collapseForm{{ $pesanan->id }}" aria-expanded="false" aria-controls="collapseForm{{ $pesanan->id }}" style="padding: 15px 20px; font-weight: bold; color: #006FFF; background: #f8fafc; border: none; text-align: left; box-shadow: none;">
                                            <span><i class="fa fa-money-bill-wave me-2 text-success"></i> Buka Form Pelepasan Dana</span>
                                            <i class="fa fa-chevron-down text-muted"></i>
                                        </button>

                                        <div class="collapse" id="collapseForm{{ $pesanan->id }}">
                                            <div class="row pelepasan-form-wrapper" style="margin: 0; padding: 25px 20px; border-top: 1px solid #e2e8f0;">
                                            <div class="col-md-12">
                                                <form class="form-lepas-dana" action="{{ route('admin.lepas-dana-jastiper', $pesanan->id) }}" method="POST">
                                                    @csrf
                                                    <h6 class="mb-3 text-primary fw-bold">Persetujuan Dana (Escrow)</h6>
                                                    
                                                    <div class="alert alert-info py-2 px-3 small mb-3">
                                                        <i class="fa fa-info-circle me-1"></i> Klik tombol di bawah ini untuk meneruskan dana sebesar <strong>Rp {{ number_format($pesanan->total_harga * 0.95, 0, ',', '.') }}</strong> ke <strong>Dompet Jastiper</strong>. 
                                                        <br>Jastiper baru bisa menarik uang tunai ke rekening mereka setelah Anda menyetujuinya di sini.
                                                    </div>

                                                    <button type="submit" class="btn btn-success btn-sm w-100 fw-bold py-2">
                                                        <i class="fa fa-check-circle me-1"></i> Teruskan ke Dompet Jastiper (Rp {{ number_format($pesanan->total_harga * 0.95, 0, ',', '.') }})
                                                    </button>
                                                </form>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning mb-0" style="font-size: 0.875rem;">
                                        <i class="fa fa-info-circle me-1"></i>
                                        Dana pesanan ini masih <strong>TERTAHAN</strong> karena status pesanan saat ini adalah: 
                                        <strong style="color: #d39e00;">{{ str_replace('_', ' ', $pesanan->status_pesanan) }}</strong>. 
                                        Anda baru bisa melepaskan dana setelah pesanan diselesaikan.
                                    </div>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                Saat ini tidak ada dana yang sedang ditahan di sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $pesanans->links() }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.form-lepas-dana').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            
            Swal.fire({
                title: 'Konfirmasi Pelepasan Dana',
                text: "Yakin ingin melepas dana ke rekening Jastiper? Pastikan Anda sudah mentransfernya ke rekening yang tertera.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lepas Dana',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('.form-tolak-dana').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            
            Swal.fire({
                title: 'Tolak Pencairan Dana?',
                text: "Anda akan melaporkan bahwa rekening Jastiper bermasalah. Jastiper akan diminta memperbarui rekeningnya.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak & Laporkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush