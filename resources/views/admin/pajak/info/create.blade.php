@extends('admin.partials.app')

@section('title', 'Tambah Info Pajak')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-cash-coin"></i> Tambah Info Pajak</h2>

    <form id="infoForm" action="{{ route('admin.pajak.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="max-width: 800px;"> {{-- diperbesar agar nyaman menulis --}}
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="fotoInput"
                    class="form-control @error('foto') is-invalid @enderror"
                    accept="image/*"> {{-- filter hanya foto --}}
                @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
                uploadUrl: "{{ route('admin.pajak.info.upload.image') }}?_token={{ csrf_token() }}"
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

<script>
document.getElementById('fotoInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    // Tipe file yang diperbolehkan
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

    // Validasi tipe file
    if (!allowedTypes.includes(file.type)) {
        alert('File harus berupa gambar');
        this.value = ""; // reset input
        return;
    }

    // Validasi ukuran maksimal 2MB (opsional)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 2MB.');
        this.value = "";
        return;
    }
});
</script>
@endsection