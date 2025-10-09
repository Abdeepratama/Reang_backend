@extends('admin.partials.app')

@section('title', 'Tambah Akun Admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">➕ Tambah Akun Admin</h2>

    {{-- Pesan sukses --}}
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error validasi --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.accounts.store') }}" method="POST">
        @csrf

        {{-- Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="Masukkan nama admin"
                required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
            </div>
            @error('password')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password"
                    required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">👁</button>
            </div>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        {{-- Nomor HP --}}
        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp') }}">
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="">-- Pilih Role --</option>
                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admindinas" {{ old('role') == 'admindinas' ? 'selected' : '' }}>Admin Dinas</option>
                <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
            </select>
            @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Instansi (hanya jika role = admindinas) --}}
        <div class="mb-3" id="instansi-wrapper" style="display: none;">
            <label for="id_instansi" class="form-label">Instansi</label>
            <select name="id_instansi" id="id_instansi" class="form-select @error('id_instansi') is-invalid @enderror">
                <option value="">-- Pilih Instansi --</option>
                @foreach ($instansis as $instansi)
                <option value="{{ $instansi->id }}" {{ old('id_instansi') == $instansi->id ? 'selected' : '' }}>
                    {{ $instansi->nama }}
                </option>
                @endforeach
            </select>
            @error('id_instansi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Dokter (hanya jika role = dokter) --}}
        <div class="mb-3" id="dokter-wrapper" style="display: none;">
            <label for="id_dokter" class="form-label">Pilih Dokter</label>
            <select name="id_dokter" id="id_dokter" class="form-select @error('id_dokter') is-invalid @enderror">
                <option value="">-- Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}" {{ old('id_dokter') == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->nama }}
                </option>
                @endforeach
            </select>
            @error('id_dokter')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-success">💾 Simpan</button>
            <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">↩ Kembali</a>
        </div>
    </form>
</div>

{{-- Script --}}
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }

    const roleSelect = document.getElementById('role');
    const instansiWrapper = document.getElementById('instansi-wrapper');
    const dokterWrapper = document.getElementById('dokter-wrapper');

    function toggleFields() {
        instansiWrapper.style.display = roleSelect.value === 'admindinas' ? 'block' : 'none';
        dokterWrapper.style.display = roleSelect.value === 'dokter' ? 'block' : 'none';
    }

    roleSelect.addEventListener('change', toggleFields);
    window.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection