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
                <label for="foto">Foto</label><br>
                <input type="file" name="foto" id="fotoInput"
                    class="form-control @error('foto') is-invalid @enderror"
                    accept="image/*">

                @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

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