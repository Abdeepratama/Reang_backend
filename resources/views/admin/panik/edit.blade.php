@extends('admin.partials.app')

@section('title', 'Edit Panik Button')

@section('content')
<div class="container mt-4">
    <h2>Edit Panik Button</h2>

    <form action="{{ route('admin.panik.update', $panik->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $panik->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
            <label>Nomor</label>
            <input type="text" name="nomer" class="form-control" value="{{ old('nomer', $panik->nomer) }}" required>
            @error('nomer') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.panik.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
