@extends('admin.partials.app')

@section('title', 'Edit Deskripsi Renbang')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-building"></i> Edit Deskripsi Renbang</h2>

    <form id="renbangForm" action="{{ route('admin.renbang.deskripsi.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="max-width: 800px;"> {{-- supaya lebih nyaman --}}
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $item->judul) }}" required>
            </div>

            <!-- Kategori -->
            <div class="form-group mb-3">
                <label>Kategori</label>
                <select name="fitur" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriRenbangs as $kategori)
                        <option value="{{ $kategori->nama }}" {{ (old('fitur', $item->fitur) == $kategori->nama) ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Foto -->
            <div class="form-group mb-3">
                <label>Foto</label>
                <input type="file" name="gambar" class="form-control">
                @if($item->gambar)
                    <small>Foto saat ini:</small><br>
                    <img src="{{ $item->gambar }}" alt="Foto" width="150" style="border-radius:8px; margin-top:5px;">
                @endif
            </div>

            <!-- Alamat -->
            <div class="form-group mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $item->alamat) }}" required>
            </div>

            <!-- Deskripsi (CKEditor) -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $item->deskripsi) }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Update Data</button>
            <a href="{{ route('admin.renbang.deskripsi.index') }}" class="btn btn-secondary">Batal</a>
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
        uploadUrl: "{{ route('admin.renbang.deskripsi.upload.image') }}?_token={{ csrf_token() }}"
    }
})
.then(instance => {
    editor = instance;
})
.catch(error => {
    console.error(error);
});

// Validasi manual sebelum submit
document.getElementById('renbangForm').addEventListener('submit', function(e) {
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
