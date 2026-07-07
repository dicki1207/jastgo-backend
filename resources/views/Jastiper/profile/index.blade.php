@extends('layout.jastiper-app')

@section('title', 'Profil Jastiper')
@section('page-title', 'Profil Saya')

@push('styles')
<style>
.profile-card {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    max-width: 650px;
    margin: 40px auto;
}

.profile-card h2,
.profile-card h4 {
    margin-bottom: 24px;
    color: #333;
}

.profile-field {
    margin-bottom: 16px;
}

.profile-field label {
    font-weight: 600;
    color: #555;
    display: block;
    margin-bottom: 6px;
}

.profile-field .value {
    background: #f9f9f9;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #ddd;
    color: #333;
}

.value-warning {
    background: #fff3cd;
    color: #856404;
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #ffeeba;
}

hr {
    margin: 32px 0;
    border-color: #eee;
}

.profile-avatar-container {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #4a90e2;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}
</style>
@endpush

@section('content')
<div class="profile-card">

    <h2>Profil Saya</h2>

    <!-- Tambahan: Bagian Foto Profil Toko -->
    <div class="profile-avatar-container">
        @php
            $profileUrl = $jastiper->profile_toko 
                ? $jastiper->profile_toko 
                : 'https://placehold.co/150x150/f0f4f8/999999?text=TOKO';
        @endphp
        <img src="{{ $profileUrl }}" alt="Foto Profil Toko" class="profile-avatar">
    </div>

    <div class="profile-field">
        <label>Nama Toko</label>
        <div class="value">{{ $jastiper->nama_toko ?? '-' }}</div>
    </div>

    <div class="profile-field">
        <label>Email</label>
        <div class="value">{{ $jastiper->user->email ?? '-' }}</div>
    </div>

    <div class="profile-field">
        <label>No. HP</label>
        <div class="value">{{ $jastiper->no_hp ?? '-' }}</div>
    </div>

    <div class="profile-field">
        <label>Kota Toko</label>
        <div class="value">{{ $jastiper->kota_toko ?? '-' }}</div>
    </div>

    <div class="profile-field">
        <label>Alamat Lengkap Toko</label>
        <div class="value">{{ $jastiper->alamat_toko ?? '-' }}</div>
    </div>

    <div class="profile-field">
        <label>Jangkauan Layanan</label>
        <div class="value">{{ $jastiper->jangkauan ?? '-' }}</div>
    </div>

    <div class="profile-field">
        <label>Rating</label>
        <div class="value">{{ $jastiper->rating ?? '0' }} / 5</div>
    </div>

    <div class="profile-field">
        <label>Tanggal Daftar</label>
        <div class="value">{{ $jastiper->tanggal_daftar?->format('d M Y') ?? '-' }}</div>
    </div>



    <a href="{{ route('jastiper.profile.edit') }}" class="btn btn-primary mt-4">Edit Profil</a>

</div>
@endsection