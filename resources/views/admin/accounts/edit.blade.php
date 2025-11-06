@extends('admin.partials.app')

@section('title', 'Edit Akun Admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">✏️ Edit Akun Admin</h2>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $account->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password (kosongkan jika tidak diubah)</label>
            <div class="input-group">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
            </div>
            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">👁</button>
            </div>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $account->userData->email ?? '') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Nomor HP --}}
        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp"
                class="form-control @error('no_hp') is-invalid @enderror"
                value="{{ old('no_hp', $account->userData->no_hp ?? '') }}">
            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Alamat --}}
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat"
                class="form-control @error('alamat') is-invalid @enderror"
                value="{{ old('alamat', $account->userData->alamat ?? '') }}">
            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="">-- Pilih Role --</option>
                <option value="superadmin" {{ old('role', $account->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admindinas" {{ old('role', $account->role) == 'admindinas' ? 'selected' : '' }}>Admin Dinas</option>
                <option value="puskesmas" {{ old('role', $account->role) == 'puskesmas' ? 'selected' : '' }}>Admin Puskesmas</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Instansi --}}
        <div class="mb-3" id="instansi-wrapper" style="display:none;">
            <label for="id_instansi" class="form-label">Instansi</label>
            <select name="id_instansi" id="id_instansi" class="form-select">
                <option value="">-- Pilih Instansi --</option>
                @foreach ($instansi as $item)
                    <option value="{{ $item->id }}" {{ old('id_instansi', $account->userData->id_instansi ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Puskesmas --}}
        <div class="mb-3" id="puskesmas-wrapper" style="display:none;">
            <label for="id_puskesmas" class="form-label">Puskesmas</label>
            <select name="id_puskesmas" id="id_puskesmas" class="form-select">
                <option value="">-- Pilih Puskesmas --</option>
                @foreach ($puskesmas as $item)
                    <option value="{{ $item->id }}" {{ old('id_puskesmas', $account->userData->id_puskesmas ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
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

    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const instansiWrapper = document.getElementById('instansi-wrapper');
        const puskesmasWrapper = document.getElementById('puskesmas-wrapper');
        const idInstansi = document.getElementById('id_instansi');
        const idPuskesmas = document.getElementById('id_puskesmas');

        function toggleFields() {
            const role = roleSelect.value;

            // Sembunyikan semua dulu
            instansiWrapper.style.display = 'none';
            puskesmasWrapper.style.display = 'none';
            idInstansi.disabled = true;
            idPuskesmas.disabled = true;

            if (role === 'admindinas') {
                instansiWrapper.style.display = 'block';
                idInstansi.disabled = false;
            } else if (role === 'puskesmas') {
                puskesmasWrapper.style.display = 'block';
                idPuskesmas.disabled = false;
            }
        }

        roleSelect.addEventListener('change', toggleFields);
        toggleFields(); // jalankan saat pertama kali
    });
</script>
@endsection
