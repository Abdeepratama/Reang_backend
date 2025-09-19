@extends('admin.partials.app')

@section('title', 'Tambah Info Renbang')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-building"></i> Tambah Info Renbang</h2>

    <form id="renbangForm" action="{{ route('admin.renbang.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="max-width: 800px;">
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
            </div>

            <!-- Kategori (fitur) -->
            <div class="form-group mb-3">
                <label>Kategori</label>
                <select name="fitur" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriRenbangs as $kategori)
                        <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="gambar" class="form-control">
            </div>

            <!-- Alamat -->
            <div class="form-group mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan Data
            </button>
        </div>
    </form>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
let editor;

ClassicEditor
    .create(document.querySelector('#editor'), {
        ckfinder: {
            uploadUrl: "{{ route('admin.renbang.info.upload.image') }}?_token={{ csrf_token() }}"
        }
    })
    .then(instance => { editor = instance; })
    .catch(error => { console.error(error); });

document.getElementById('renbangForm').addEventListener('submit', function(e) {
    if (editor && editor.getData().trim() === '') {
        e.preventDefault();
        alert('Deskripsi harus diisi');
        return false;
    }

    const fileInput = document.querySelector('input[name="gambar"]');
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            e.preventDefault();
            alert('Hanya file JPEG, PNG, JPG, dan WEBP yang diizinkan');
            return false;
        }
    }
});
</script>
@endsection
