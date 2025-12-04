@extends('admin.partials.app')

@section('title', 'Edit Kategori DUMAS')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white py-3">
                    <h4 class="mb-0 text-center text-white">Edit Kategori DUMAS</h4>
                </div>

                <div class="card-body px-4 py-4">

                    <form action="{{ route('admin.kategori_dumas.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Pilih Instansi --}}
                        <div class="mb-4">
                            <label for="id_instansi" class="form-label fw-semibold">Instansi</label>
                            <select class="form-select shadow-sm" id="id_instansi" name="id_instansi" required>
                                <option value="" disabled>Pilih Instansi</option>
                                @foreach($instansis as $instansi)
                                    <option value="{{ $instansi->id }}"
                                        {{ $kategori->id_instansi == $instansi->id ? 'selected' : '' }}>
                                        {{ $instansi->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Kategori --}}
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text"
                                   class="form-control shadow-sm"
                                   id="nama_kategori"
                                   name="nama_kategori"
                                   required
                                   value="{{ $kategori->nama_kategori }}"
                                   placeholder="Contoh: Kesehatan, Kependudukan, Pendidikan">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategori_dumas.index') }}" class="btn btn-secondary px-4">
                                <i class="fe fe-arrow-left"></i> Kembali
                            </a>

                            <button type="submit" class="btn bg-success text-white px-4">
                                <i class="fe fe-save"></i> Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
