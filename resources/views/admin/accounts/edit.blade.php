@extends('admin.partials.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">✏️ Edit Akun Admin</h3>

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

    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $account->name) }}" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
            </div>
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">👁</button>
            </div>
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="superadmin" {{ old('role', $account->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admindinas" {{ old('role', $account->role) == 'admindinas' ? 'selected' : '' }}>Admin Dinas</option>
                <option value="dokter" {{ old('role', $account->role) == 'dokter' ? 'selected' : '' }}>Dokter</option>
            </select>
        </div>

        {{-- Pilih Instansi (untuk Admin Dinas) --}}
        <div class="mb-3" id="instansi-wrapper" style="display:none;">
            <label for="id_instansi" class="form-label">Pilih Instansi</label>
            <select name="id_instansi" id="id_instansi" class="form-control">
                <option value="">-- Pilih Instansi --</option>
                @foreach ($instansi as $item)
                <option value="{{ $item->id }}"
                    {{ old('id_instansi', $account->id_instansi) == $item->id ? 'selected' : '' }}>
                    {{ $item->nama }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Dokter (untuk Role Dokter) --}}
        <div class="mb-3" id="dokter-wrapper" style="display:none;">
            <label for="id_dokter" class="form-label">Pilih Dokter</label>
            <select name="id_dokter" id="id_dokter" class="form-control">
                <option value="">-- Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}"
                    {{ old('id_dokter', $account->id_dokter) == $dokter->id ? 'selected' : '' }}>
                    {{ $dokter->nama }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email (Opsional)</label>
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', $account->userData->email ?? '') }}">
        </div>

        {{-- Nomor HP --}}
        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor HP (Opsional)</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control"
                value="{{ old('no_hp', $account->userData->no_hp ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">⬅️ Kembali</a>
    </form>
</div>

{{-- Script --}}
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }

    // tampilkan field sesuai role
    function toggleFields() {
        const role = document.getElementById('role').value;
        const instansiWrapper = document.getElementById('instansi-wrapper');
        const dokterWrapper = document.getElementById('dokter-wrapper');

        instansiWrapper.style.display = (role === 'admindinas') ? 'block' : 'none';
        dokterWrapper.style.display = (role === 'dokter') ? 'block' : 'none';
    }

    // inisialisasi saat load & saat role berubah
    document.getElementById('role').addEventListener('change', toggleFields);
    toggleFields();
</script>
@endsection