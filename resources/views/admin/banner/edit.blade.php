@extends('admin.partials.app')

@section('title', 'Edit Banner')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-pencil-square"></i> Edit Banner</h2>

    <form id="bannerForm" action="{{ route('admin.banner.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="max-width: 800px;">
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $item->judul) }}" required>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label>Foto</label><br>
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Banner" width="150" class="mb-2 rounded">
                @endif
                <input type="file" name="foto" class="form-control" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto</small>
            </div>

            <!-- Deskripsi -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $item->deskripsi) }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Perbarui Banner
            </button>
            <a href="{{ route('admin.banner.index') }}" class="btn btn-secondary">Batal</a>
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
        uploadUrl: "{{ route('admin.banner.upload.image') }}?_token={{ csrf_token() }}"
    }
})
.then(instance => {
    editor = instance;
})
.catch(error => {
    console.error(error);
});

document.getElementById('bannerForm').addEventListener('submit', function(e) {
    if (editor && editor.getData().trim() === '') {
        e.preventDefault();
        alert('Deskripsi harus diisi');
        return false;
    }
});
</script>
@endsection
