@extends('admin.partials.app')

@section('title', 'Edit Data Sehat')

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 mb-4">Edit Data Sehat</h4>

    <form action="{{ route('admin.sehat.tempat.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <!-- Nama -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Tempat Sehat</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $item->name) }}" required>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control"
                           value="{{ old('address', $item->address ?? '') }}" required>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="fitur" class="form-label">Kategori</label>
                    <select name="fitur" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriSehat as $kategori)
                        <option value="{{ $kategori->nama }}" {{ $item->fitur == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Foto -->
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <div class="mb-2">
                        @if($item->foto)
                            <img id="currentPreview" src="{{ Storage::url($item->foto) }}" 
                                 alt="Foto {{ $item->name }}" 
                                 style="max-width:150px; height:auto; border:1px solid #ddd; padding:4px;">
                        @else
                            <img id="currentPreview" src="{{ asset('images/default-sehat.jpg') }}" 
                                 alt="Default" 
                                 style="max-width:150px; height:auto; border:1px solid #ddd; padding:4px;">
                        @endif
                    </div>
                    <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </div>
    </form>
</div>
@endsection
