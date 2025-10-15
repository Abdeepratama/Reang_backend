@extends('admin.partials.app')

@section('title', 'Edit Info Perizinan-Yu')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-file-earmark-text"></i> Edit Info Perizinan</h2>

    <form id="infoForm" action="{{ route('admin.izin.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="max-width: 800px;">
            <!-- Judul -->
            <div class="form-group mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $info->judul) }}" required>
            </div>

            <!-- Kategori -->
            <div class="form-group mb-3">
                <label>Kategori</label>
                <select name="fitur" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriPerizinan as $kategori)
                    <option value="{{ $kategori->nama }}" {{ (old('fitur', $info->fitur) == $kategori->nama) ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                    @endforeach
                </select>
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

            <!-- Deskripsi -->
            <div class="form-group mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $info->deskripsi) }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Update Data</button>
            <a href="{{ route('admin.izin.info.index') }}" class="btn btn-secondary">Batal</a>
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
                uploadUrl: "{{ route('admin.izin.info.upload.image') }}?_token={{ csrf_token() }}"
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
    });
</script>
@endsection