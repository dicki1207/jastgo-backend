@extends('layout.jastiper-app')

@section('title', 'Tambah Barang')
@section('page-title', 'Tambah Barang')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/css/custom-form.css') }}">
@endpush

@section('content')
<div class="form-panel">
    <h2 class="form-title">Tambah Barang</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-3"><ul class="mb-0">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul></div>
    @endif

    <form action="{{ route('jastiper.barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- kategori_id --}}
        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-control">
                <option value="">-- Pilih kategori (opsional) --</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- nama_barang --}}
        <div class="form-group">
            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required maxlength="150">
        </div>

        {{-- deskripsi --}}
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-row">
            <div class="col form-group">
                <label class="form-label"> Ongkos Jastip (Rp) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="harga" class="form-control" value="{{ old('harga', 0) }}" required>
            </div>

            <div class="col form-group">
                <label class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" required>
            </div>
        </div>

        {{-- is_available --}}
        <div class="form-group">
            <label class="form-label">Tersedia</label>
            <select name="is_available" class="form-control">
                <option value="yes" {{ old('is_available','yes') == 'yes' ? 'selected' : '' }}>yes</option>
                <option value="no"  {{ old('is_available') == 'no' ? 'selected' : '' }}>no</option>
            </select>
        </div>

        {{-- Foto Barang (Maksimal 3 Foto) --}}
        <div class="form-group">
            <label class="form-label">Foto Barang (opsional, maks 3 foto)</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 10px;">
                
                {{-- FOTO 1 --}}
                <div class="photo-upload-box">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #555;">Foto Utama</label>
                    <input type="file" name="foto_barang" id="fotoInput1" class="form-control" accept=".jpg,.jpeg,.png">
                    <div id="previewWrapper1" class="preview-wrapper"></div>
                </div>

                {{-- FOTO 2 --}}
                <div class="photo-upload-box">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #555;">Foto Tambahan 1</label>
                    <input type="file" name="foto_barang_2" id="fotoInput2" class="form-control" accept=".jpg,.jpeg,.png">
                    <div id="previewWrapper2" class="preview-wrapper"></div>
                </div>

                {{-- FOTO 3 --}}
                <div class="photo-upload-box">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #555;">Foto Tambahan 2</label>
                    <input type="file" name="foto_barang_3" id="fotoInput3" class="form-control" accept=".jpg,.jpeg,.png">
                    <div id="previewWrapper3" class="preview-wrapper"></div>
                </div>

            </div>
            <small class="form-help">Format: jpg, jpeg, png. Ukuran maksimal 2MB per foto.</small>
        </div>

        {{-- tanggal_input --}}
        <div class="form-group">
            <label class="form-label">Tanggal Input (opsional)</label>
            <input type="datetime-local" name="tanggal_input" class="form-control"
                   value="{{ old('tanggal_input') }}">
            <small class="form-help">Kosongkan agar otomatis.</small>
        </div>

        <div class="form-actions">
            <a href="{{ route('jastiper.barang.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .photo-upload-box {
        border: 2px dashed #ddd;
        border-radius: 12px;
        padding: 15px;
        background: #fafafa;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .photo-upload-box:hover {
        border-color: #006FFF;
        background: #f0f7ff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 111, 255, 0.1);
    }
    .preview-wrapper {
        margin-top: 5px;
    }
    .preview-wrapper img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupImagePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (input) {
            input.addEventListener('change', function () {
                preview.innerHTML = '';
                const file = this.files && this.files[0];
                if (!file) return;
                if (!file.type.startsWith('image/')) return;

                const img = document.createElement('img');
                img.alt = 'preview';

                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    setupImagePreview('fotoInput1', 'previewWrapper1');
    setupImagePreview('fotoInput2', 'previewWrapper2');
    setupImagePreview('fotoInput3', 'previewWrapper3');
});
</script>
@endpush
