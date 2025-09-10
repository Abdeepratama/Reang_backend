@extends('admin.partials.app')

@section('title', 'Edit Info Adminduk')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-pencil-square"></i> Edit Info Adminduk</h2>

    <form id="infoForm" action="{{ route('admin.adminduk.info.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="max-width: 800px;">
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" id="judul" class="form-control"
                    value="{{ old('judul', $item->judul) }}" required>
            </div>

            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control">
                @if($item->foto)
                <small>Foto saat ini:</small><br>
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto"
                    width="150" style="border-radius:8px; margin-top:5px;">
                @endif
            </div>

            <!-- Deskripsi -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $item->deskripsi) }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Data
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
                uploadUrl: "{{ route('admin.adminduk.info.upload.image') }}?_token={{ csrf_token() }}"
            }
        })
        .then(instance => {
            editor = instance;
        })
        .catch(error => {
            console.error(error);
        });

    document.getElementById('infoForm').addEventListener('submit', function(e) {
        if (editor && editor.getData().trim() === '') {
            e.preventDefault();
            alert('Deskripsi harus diisi');
            return false;
        }

        if (editor) {
            let content = editor.getData();
            content = content.replace(/<table(?![^>]*border)/g, '<table border="1" cellpadding="8" cellspacing="0"');
            document.querySelector('#editor').value = content;
        }
    });
</script>
@endsection