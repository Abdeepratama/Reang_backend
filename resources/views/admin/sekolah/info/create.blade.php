@extends('admin.partials.app')

@section('title', 'Tambah Info Sekolah')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-hospital"></i> Tambah Info Sekolah</h2>

    <form id="infoForm" action="{{ route('admin.sekolah.info.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="max-width: 800px;">
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <!-- Foto -->
            <div class="mb-3">
                <label for="foto">Foto</label>
                <input type="file"
                    name="foto"
                    id="fotoInput"
                    class="form-control @error('foto') is-invalid @enderror"
                    accept="image/*"> {{-- Hanya bisa pilih gambar --}}

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

<script>
    document.getElementById('fotoInput').addEventListener('change', function() {
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