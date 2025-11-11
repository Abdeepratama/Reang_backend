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
            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control" required>
            </div>

            <!-- Deskripsi -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <small class="text-muted">Maksimal 255 karakter.</small>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5"></textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection


{{-- Semua script diletakkan di bawah agar CKEditor dimuat setelah halaman siap --}}
@section('scripts')
<!-- Load CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi CKEditor
        let editorInstance;

        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "{{ route('admin.sekolah.info.upload.image') }}?_token={{ csrf_token() }}"
                }
            })
            .then(instance => {
                editorInstance = instance;
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });

        // Validasi form sebelum submit
        document.getElementById('infoForm').addEventListener('submit', function(e) {
            if (!editorInstance) {
                e.preventDefault();
                alert('Editor belum siap. Silakan tunggu beberapa detik dan coba lagi.');
                return false;
            }

            const deskripsi = editorInstance.getData().trim();

            // kalau kosong, stop
            if (deskripsi === '') {
                e.preventDefault();
                alert('Deskripsi harus diisi');
                return false;
            }

            // simpan isi CKEditor ke textarea supaya terkirim ke Laravel
            document.querySelector('textarea[name="deskripsi"]').value = deskripsi;

            // validasi file
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
    });
</script>
@endsection