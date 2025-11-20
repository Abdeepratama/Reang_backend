@extends('admin.partials.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 text-center text-white">Tambah Kategori</h4>
                </div>

                <div class="card-body px-4 py-4">

                    <form action="{{ route('admin.kategori.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Fitur --}}
                        <div class="mb-4">
                            <label for="fitur" class="form-label fw-semibold">Kategori Fitur</label>
                            <select class="form-select shadow-sm" id="fitur" name="fitur" required>
                                <option value="" disabled selected>Pilih Fitur</option>
                                @foreach (fitur_list() as $fitur)
                                <option value="{{ $fitur }}">{{ ucfirst($fitur) }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Kategori --}}
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text"
                                class="form-control shadow-sm"
                                id="nama" name="nama"
                                required
                                placeholder="Contoh: Masjid, wisata, Pasar">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary px-4">
                                <i class="fe fe-arrow-left"></i> Kembali
                            </a>

                            <button type="submit" class="btn btn-success px-4">
                                <i class="fe fe-save"></i> Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection