@extends('admin.partials.app')

@section('title', 'Edit Info Kerja')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-briefcase"></i> Edit Info Kerja</h2>

    <form id="infoForm" action="{{ route('admin.kerja.info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="max-width: 800px;">
            <!-- Nama Perusahaan -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Perusahaan</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $info->name) }}" required>
            </div>

            <!-- Judul -->
            <div class="mb-3">
                <label for="judul" class="form-label">Posisi</label>
                <input type="text" name="judul" id="judul" class="form-control"
                    value="{{ old('judul', $info->judul) }}" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $info->alamat) }}</textarea>
            </div>

            <!-- Gaji -->
            <div class="mb-3">
                <label for="gaji" class="form-label">Gaji</label>
                <input type="text" name="gaji" id="gaji" class="form-control"
                    value="{{ old('gaji', $info->gaji) }}">
            </div>

            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control"
                    value="{{ old('nomor_telepon', $info->nomor_telepon) }}">
            </div>

            <!-- Waktu Kerja -->
            <div class="mb-3">
                <label for="waktu_kerja" class="form-label">Waktu Kerja</label>
                <input type="text" name="waktu_kerja" id="waktu_kerja" class="form-control"
                    value="{{ old('waktu_kerja', $info->waktu_kerja) }}">
            </div>

            <!-- Jenis Kerja -->
            <div class="mb-3">
                <label for="jenis_kerja" class="form-label">Jenis Kerja</label>
                <input type="text" name="jenis_kerja" id="jenis_kerja" class="form-control"
                    value="{{ old('jenis_kerja', $info->jenis_kerja) }}">
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label for="fitur" class="form-label">Kategori</label>
                <select name="fitur" id="fitur" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriKerja as $kategori)
                    <option value="{{ $kategori->nama }}"
                        {{ old('fitur', $info->fitur) == $kategori->nama ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Foto -->
            <div class="mb-3">
                <label for="foto">Foto</label><br>
                <input type="file" name="foto" id="fotoInput"
                    class="form-control @error('foto') is-invalid @enderror"
                    accept="image/*">

                @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if($info->foto)
                <img src="{{ Storage::url($info->foto) }}" width="150" class="mb-2 rounded">
                @endif
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="editor" class="form-control" rows="5">{{ old('deskripsi', $info->deskripsi) }}</textarea>
            </div>

            <!-- Tombol -->
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Update Data
            </button>
            <a href="{{ route('admin.kerja.info.index') }}" class="btn btn-secondary">Kembali</a>
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
                uploadUrl: "{{ route('admin.kerja.info.upload.image') }}?_token={{ csrf_token() }}"
            }
        })
        .then(instance => {
            editor = instance;
        })
        .catch(error => {
            console.error(error);
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