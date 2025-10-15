@extends('admin.partials.app')

@section('title', 'Edit Info Pajak')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-cash-stack"></i> Edit Info Pajak</h2>

    <form id="infoForm" action="{{ route('admin.pajak.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="max-width: 800px;"> {{-- supaya lebih nyaman --}}
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $info->judul) }}" required>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">

                @if($info->foto)
                <small>Foto saat ini:</small><br>
                <img src="{{ asset('storage/' . $info->foto) }}"
                    alt="Foto"
                    width="150"
                    style="border-radius:8px; margin-top:5px;">
                @endif
            </div>

            <!-- Deskripsi (CKEditor) -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $info->deskripsi) }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Update Data
            </button>
            <a href="{{ route('admin.pajak.info.index') }}" class="btn btn-secondary">Batal</a>
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
});
</script>
@endsection
