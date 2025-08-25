@extends('admin.partials.app')

@section('title', 'Tambah Info Sehat-Yu')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-hospital"></i> Tambah Info Sehat</h2>

    <form id="infoForm" action="{{ route('admin.sehat.info.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div style="max-width: 800px;"> {{-- diperbesar agar nyaman menulis --}}
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <!-- Kategori -->
            <div class="form-group mb-3">
                <label>Kategori</label>
                <select name="fitur" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriKesehatan as $kategori)
                        <option value="{{ $kategori->nama }}" {{ old('fitur') == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control" required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5"></textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan Data
            </button>
        </div>
    </form>
</div>

{{-- CKEditor Script --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
// Inisialisasi CKEditor
let editor;

ClassicEditor
.create(document.querySelector('#editor'), {
    ckfinder: {
        uploadUrl: "{{ route('admin.sehat.info.upload.image') }}?_token={{ csrf_token() }}"
    }
})
.then(instance => {
    editor = instance;
})
.catch(error => {
    console.error(error);
});

// Validasi manual sebelum submit
document.getElementById('infoForm').addEventListener('submit', function(e) {
    // Validasi CKEditor content
    if (editor && editor.getData().trim() === '') {
        e.preventDefault();
        alert('Deskripsi harus diisi');
        return false;
    }
    
    // Validasi file type
    const fileInput = document.querySelector('input[name="foto"]');
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            e.preventDefault();
            alert('Hanya file JPEG, PNG, dan JPG yang diizinkan');
            return false;
        }
    }
});
</script>
@endsection
