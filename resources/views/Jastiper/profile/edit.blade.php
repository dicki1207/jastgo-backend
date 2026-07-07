@extends('layout.jastiper-app')

@section('title', 'Edit Profil Jastiper')
@section('page-title', 'Edit Profil Saya')

@section('content')
<div class="container">
    <div class="card p-4" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4">Edit Profil Jastiper</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('jastiper.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4 text-center">
                @php
                    $profileUrl = $jastiper->profile_toko 
                        ? asset('storage/' . $jastiper->profile_toko) 
                        : 'https://placehold.co/150x150/f0f4f8/999999?text=TOKO';
                @endphp
                <img src="{{ $profileUrl }}" alt="Foto Profil Toko" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 3px solid #ccc;">
                <p class="mb-2">Foto Profil Toko</p>
                <input type="file" name="profile_toko" class="form-control @error('profile_toko') is-invalid @enderror" accept="image/*">
                @error('profile_toko')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nama Toko <span class="text-danger">*</span></label>
                <input type="text" name="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror" 
                        value="{{ old('nama_toko', $jastiper->nama_toko) }}" required>
                @error('nama_toko')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">No HP </label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                        value="{{ old('no_hp', $jastiper->no_hp) }}">
                @error('no_hp')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kota Toko</label>
                <input type="text" name="kota_toko" class="form-control @error('kota_toko') is-invalid @enderror" 
                        value="{{ old('kota_toko', $jastiper->kota_toko) }}">
                @error('kota_toko')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Lengkap Toko</label>
                <textarea name="alamat_toko" rows="3" class="form-control @error('alamat_toko') is-invalid @enderror">{{ old('alamat_toko', $jastiper->alamat_toko) }}</textarea>
                @error('alamat_toko')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Jangkauan Layanan</label>
                <input type="text" name="jangkauan" class="form-control @error('jangkauan') is-invalid @enderror" 
                        value="{{ old('jangkauan', $jastiper->jangkauan) }}">
                @error('jangkauan')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr>
            <h5>Data Rekening</h5>
            <div class="alert alert-info">
                Pengaturan Rekening Bank sekarang dipindahkan ke menu tersendiri agar Anda dapat mengelola lebih dari satu rekening.
                <br>
                <a href="{{ route('jastiper.rekening.index') }}" class="btn btn-sm btn-outline-primary mt-2">Kelola Rekening Bank</a>
            </div>

            <button class="btn btn-primary mt-3" type="submit">Simpan Profil</button>
            <a href="{{ route('jastiper.profile.index') }}" class="btn btn-secondary ms-2 mt-3">Batal</a>
        </form>
    </div>
</div>
@endsection