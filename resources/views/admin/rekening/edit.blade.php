@extends('layout.admin-app')

@section('title', 'Edit Rekening')
@section('page-title', 'Edit Rekening')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/css/custom-form.css') }}">
@endpush

@section('content')
<div class="form-panel">
    <h2 class="form-title">Edit Rekening (ID: {{ $rekening->id }})</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-4" style="margin-bottom:18px; padding:10px 14px; border-radius:8px; background:#fff0f0; border:1px solid #f2c6c6; color:#8a1f1f;">
            <ul class="mb-0" style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rekening.update', $rekening) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        {{-- Field: user_id (User ID ditampilkan, tidak bisa diubah) --}}
        <div class="form-group">
            <label class="form-label">User ID Pemilik</label>
            <input type="text" value="{{ $rekening->user_id }}" class="form-control" disabled>
        </div>
        
        <div class="alert alert-info mb-4" style="margin-bottom:18px; padding:10px 14px; border-radius:8px; background:#e8f4fd; border:1px solid #b8daff; color:#004085;">
            <i class="fas fa-info-circle"></i> <strong>Catatan Keamanan:</strong> Demi menjaga integritas data historis, Tipe Rekening, Nama Bank/E-Wallet, dan Nomor Akun tidak dapat diubah. Jika ada kesalahan, silakan nonaktifkan rekening ini dan buat yang baru.
        </div>

        {{-- Field: tipe_rekening (Disabled) --}}
        <div class="form-group">
            <label class="form-label">Tipe Rekening</label>
            <input type="text" value="{{ ucfirst($rekening->tipe_rekening) }}" class="form-control" disabled style="background-color: #f8f9fa;">
        </div>

        {{-- Field: nama_penyedia (Disabled) --}}
        <div class="form-group">
            <label class="form-label">Nama Penyedia (Bank/E-Wallet)</label>
            <input type="text" value="{{ $rekening->nama_penyedia }}" class="form-control" disabled style="background-color: #f8f9fa;">
        </div>

        {{-- Field: nama_pemilik --}}
        <div class="form-group">
            <label class="form-label">Nama Pemilik Akun <span class="text-danger">*</span></label>
            <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $rekening->nama_pemilik) }}" class="form-control" required maxlength="100">
            @error('nama_pemilik') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        
        {{-- Field: nomor_akun (Disabled) --}}
        <div class="form-group">
            <label class="form-label">Nomor Akun/Nomor Telepon</label>
            <input type="text" value="{{ $rekening->nomor_akun }}" class="form-control" disabled style="background-color: #f8f9fa; letter-spacing: 1px; font-weight: bold;">
        </div>
        
        {{-- Field: status_aktif (Enum/Select) --}}
        <div class="form-group">
            <label class="form-label">Status Aktif <span class="text-danger">*</span></label>
            <select name="status_aktif" class="form-control" required>
                @php $oldStatus = old('status_aktif', $rekening->status_aktif); @endphp
                <option value="aktif" {{ $oldStatus == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $oldStatus == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status_aktif') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.rekening.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui Rekening</button>
        </div>
    </form>
</div>
@endsection