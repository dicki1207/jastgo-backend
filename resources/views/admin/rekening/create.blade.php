@extends('layout.admin-app')

@section('title', 'Tambah Rekening')
@section('page-title', 'Tambah Rekening')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/css/custom-form.css') }}">
@endpush

@section('content')
<div class="form-panel">
    <h2 class="form-title">Tambah Rekening</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-4" style="margin-bottom:18px; padding:10px 14px; border-radius:8px; background:#fff0f0; border:1px solid #f2c6c6; color:#8a1f1f;">
            <ul class="mb-0" style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rekening.store') }}" method="POST" autocomplete="off">
        @csrf


        {{-- Tipe Rekening disembunyikan dan diset via JS berdasarkan pilihan penyedia --}}
        <input type="hidden" name="tipe_rekening" id="tipe_rekening" value="{{ old('tipe_rekening') }}">
        
        <style>
            .bank-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
                margin-bottom: 20px;
            }
            .bank-card {
                border: 2px solid #eee;
                border-radius: 8px;
                padding: 15px;
                text-align: center;
                cursor: pointer;
                transition: all 0.2s;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 10px;
                background: #fff;
            }
            .bank-card:hover {
                border-color: #C1E0F4;
                background: #f8fbff;
            }
            .bank-card img {
                height: 30px;
                max-width: 100px;
                object-fit: contain;
            }
            .bank-card input[type="radio"] {
                display: none;
            }
            .bank-card input[type="radio"]:checked + .bank-content {
                font-weight: bold;
                color: #006FFF;
            }
            /* When input is checked, style the parent label */
            .bank-card:has(input[type="radio"]:checked) {
                border-color: #006FFF;
                background: #f0f8ff;
                box-shadow: 0 0 0 2px rgba(0, 111, 255, 0.2);
            }
            .section-label {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 10px;
                color: #555;
            }
        </style>

        <div class="form-group">
            <label class="form-label">Pilih Penyedia Bank / E-Wallet <span class="text-danger">*</span></label>
            @error('nama_penyedia') <div class="text-danger" style="margin-bottom: 10px;">{{ $message }}</div> @enderror
            @error('tipe_rekening') <div class="text-danger" style="margin-bottom: 10px;">{{ $message }}</div> @enderror
            
            <div class="section-label"><i class="fas fa-university"></i> Transfer Bank (Virtual Account)</div>
            <div class="bank-grid">
                <label class="bank-card" onclick="setTipe('bank')">
                    <input type="radio" name="nama_penyedia" value="BCA" {{ old('nama_penyedia') == 'BCA' ? 'checked' : '' }} required>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA">
                        <div>BCA</div>
                    </div>
                </label>
                <label class="bank-card" onclick="setTipe('bank')">
                    <input type="radio" name="nama_penyedia" value="BNI" {{ old('nama_penyedia') == 'BNI' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg" alt="BNI">
                        <div>BNI</div>
                    </div>
                </label>
                <label class="bank-card" onclick="setTipe('bank')">
                    <input type="radio" name="nama_penyedia" value="BRI" {{ old('nama_penyedia') == 'BRI' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_2020.svg" alt="BRI">
                        <div>BRI</div>
                    </div>
                </label>
                <label class="bank-card" onclick="setTipe('bank')">
                    <input type="radio" name="nama_penyedia" value="Mandiri" {{ old('nama_penyedia') == 'Mandiri' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri">
                        <div>Mandiri</div>
                    </div>
                </label>
                <label class="bank-card" onclick="setTipe('bank')">
                    <input type="radio" name="nama_penyedia" value="Permata" {{ old('nama_penyedia') == 'Permata' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/38/PermataBank_logo.svg" alt="Permata">
                        <div>Permata</div>
                    </div>
                </label>
            </div>

            <div class="section-label mt-4"><i class="fas fa-wallet"></i> E-Wallet & QRIS</div>
            <div class="bank-grid">
                <label class="bank-card" onclick="setTipe('e-wallet')">
                    <input type="radio" name="nama_penyedia" value="GoPay" {{ old('nama_penyedia') == 'GoPay' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="GoPay">
                        <div>GoPay</div>
                    </div>
                </label>
                <label class="bank-card" onclick="setTipe('e-wallet')">
                    <input type="radio" name="nama_penyedia" value="OVO" {{ old('nama_penyedia') == 'OVO' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Logo_ovo_purple.svg" alt="OVO">
                        <div>OVO</div>
                    </div>
                </label>
                <label class="bank-card" onclick="setTipe('e-wallet')">
                    <input type="radio" name="nama_penyedia" value="DANA" {{ old('nama_penyedia') == 'DANA' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg" alt="DANA">
                        <div>DANA</div>
                    </div>
                </label>
                <label class="bank-card" onclick="setTipe('e-wallet')">
                    <input type="radio" name="nama_penyedia" value="ShopeePay" {{ old('nama_penyedia') == 'ShopeePay' ? 'checked' : '' }}>
                    <div class="bank-content">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fe/Shopee.svg" alt="ShopeePay" style="height: 25px;">
                        <div>ShopeePay</div>
                    </div>
                </label>
            </div>
        </div>

        <script>
            function setTipe(tipe) {
                document.getElementById('tipe_rekening').value = tipe;
            }
        </script>

        {{-- Field: nama_pemilik --}}
        <div class="form-group">
            <label class="form-label">Nama Pemilik Akun <span class="text-danger">*</span></label>
            <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}" class="form-control" required maxlength="100" placeholder="Sesuai nama di buku tabungan/akun">
            @error('nama_pemilik') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        
        {{-- Field: nomor_akun --}}
        <div class="form-group">
            <label class="form-label">Nomor Akun/Nomor Telepon <span class="text-danger">*</span></label>
            <input type="text" name="nomor_akun" value="{{ old('nomor_akun') }}" class="form-control" required maxlength="50" placeholder="Contoh: 1234567890 / 0812xxxxxx">
            @error('nomor_akun') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.rekening.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Rekening</button>
        </div>
    </form>
</div>
@endsection