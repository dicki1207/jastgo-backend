@extends('layout.jastiper-app')

@section('title', 'Edit Barang')
@section('page-title', 'Edit Barang')

@push('styles')
<link rel="stylesheet" href="{{ asset('admin/assets/css/custom-form.css') }}">
@endpush

@section('content')
<div class="form-panel">
    <h2 class="form-title">Edit Barang #{{ $barang->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-3"><ul class="mb-0">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul></div>
    @endif

    <form action="{{ route('jastiper.barang.update', $barang) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')

        {{-- Kategori --}}
        <div class="form-group">
            <label class="form-label">Kategori</label>
            <select name="kategori_id" class="form-control">
                <option value="">-- Pilih kategori (opsional) --</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ (string) old('kategori_id', $barang->kategori_id) === (string) $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Nama Barang --}}
        <div class="form-group">
            <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
            <input type="text" name="nama_barang" class="form-control"
                   value="{{ old('nama_barang', $barang->nama_barang) }}" required maxlength="150" placeholder="Nama barang">
            @error('nama_barang') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="form-group">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi singkat (opsional)">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Harga + Stok --}}
        <div class="form-row">
            <div class="col form-group">
                <label class="form-label">Ongkos Jastip (Rp) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="harga" class="form-control"
                       value="{{ old('harga', $barang->harga) }}" required placeholder="0.00">
                @error('harga') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="col form-group">
                <label class="form-label">Stok <span class="text-danger">*</span></label>
                <input type="number" name="stok" class="form-control"
                       value="{{ old('stok', $barang->stok) }}" required placeholder="Jumlah stok">
                @error('stok') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Tersedia --}}
        <div class="form-group">
            <label class="form-label">Tersedia</label>
            <select name="is_available" class="form-control">
                <option value="yes" {{ old('is_available', $barang->is_available) == 'yes' ? 'selected' : '' }}>yes</option>
                <option value="no"  {{ old('is_available', $barang->is_available) == 'no' ? 'selected' : '' }}>no</option>
            </select>
            @error('is_available') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Foto Barang (Maksimal 3 Foto) --}}
        <div class="form-group">
            <label class="form-label">Foto Barang (opsional, maks 3 foto)</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 10px;">
                
                {{-- FOTO 1 --}}
                <div class="photo-upload-box">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #555;">Foto Utama</label>
                    @if($barang->foto_barang)
                        <div class="current-photo">
                            <img src="{{ asset('storage/' . $barang->foto_barang) }}" alt="foto 1">
                            <label class="remove-photo-label">
                                <input type="checkbox" name="remove_foto" value="1"> Hapus
                            </label>
                        </div>
                    @endif
                    <input type="file" name="foto_barang" id="fotoInput1" class="form-control" accept=".jpg,.jpeg,.png">
                    <div id="previewWrapper1" class="preview-wrapper"></div>
                    @error('foto_barang') <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div> @enderror
                </div>

                {{-- FOTO 2 --}}
                <div class="photo-upload-box">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #555;">Foto Tambahan 1</label>
                    @if($barang->foto_barang_2)
                        <div class="current-photo">
                            <img src="{{ asset('storage/' . $barang->foto_barang_2) }}" alt="foto 2">
                            <label class="remove-photo-label">
                                <input type="checkbox" name="remove_foto_2" value="1"> Hapus
                            </label>
                        </div>
                    @endif
                    <input type="file" name="foto_barang_2" id="fotoInput2" class="form-control" accept=".jpg,.jpeg,.png">
                    <div id="previewWrapper2" class="preview-wrapper"></div>
                    @error('foto_barang_2') <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div> @enderror
                </div>

                {{-- FOTO 3 --}}
                <div class="photo-upload-box">
                    <label style="font-weight: 600; font-size: 0.9rem; color: #555;">Foto Tambahan 2</label>
                    @if($barang->foto_barang_3)
                        <div class="current-photo">
                            <img src="{{ asset('storage/' . $barang->foto_barang_3) }}" alt="foto 3">
                            <label class="remove-photo-label">
                                <input type="checkbox" name="remove_foto_3" value="1"> Hapus
                            </label>
                        </div>
                    @endif
                    <input type="file" name="foto_barang_3" id="fotoInput3" class="form-control" accept=".jpg,.jpeg,.png">
                    <div id="previewWrapper3" class="preview-wrapper"></div>
                    @error('foto_barang_3') <div class="text-danger" style="font-size:0.8rem;">{{ $message }}</div> @enderror
                </div>

            </div>
            <small class="form-help">Format: jpg, jpeg, png. Ukuran maksimal 2MB per foto.</small>
        </div>

        {{-- Tanggal Input --}}
        <div class="form-group">
            <label class="form-label">Tanggal Input (opsional)</label>
            <input type="datetime-local" name="tanggal_input" class="form-control"
                   value="{{ old('tanggal_input', $barang->tanggal_input ? \Carbon\Carbon::parse($barang->tanggal_input)->format('Y-m-d\TH:i') : '') }}">
            <small class="form-help">Kosongkan agar otomatis.</small>
            @error('tanggal_input') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Aksi --}}
        <div class="form-actions">
            <a href="{{ route('jastiper.barang.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    .current-photo {
        position: relative;
        width: 100%;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eee;
        background: white;
    }
    .current-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .current-photo:hover img {
        transform: scale(1.05);
    }
    .remove-photo-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(255, 49, 49, 0.9);
        color: white;
        padding: 5px;
        text-align: center;
        font-size: 0.8rem;
        cursor: pointer;
        margin: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .current-photo:hover .remove-photo-label {
        opacity: 1;
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
