@extends('admin.partials.app')

@section('title', 'Tambah Info Perizinan-Yu')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-file-earmark-text"></i> Tambah Info Perizinan</h2>

    <form id="infoForm" action="{{ route('admin.izin.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="max-width: 800px;">
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
                    @foreach($kategoriPerizinan as $kategori)
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
let editor;
ClassicEditor
.create(document.querySelector('#editor'), {
    ckfinder: {
        uploadUrl: "{{ route('admin.izin.info.upload.image') }}?_token={{ csrf_token() }}"
    }
})
.then(instance => { editor = instance; })
.catch(error => { console.error(error); });

document.getElementById('infoForm').addEventListener('submit', function(e) {
    if (editor && editor.getData().trim() === '') {
        e.preventDefault();
        alert('Deskripsi harus diisi');
        return false;
    }

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
