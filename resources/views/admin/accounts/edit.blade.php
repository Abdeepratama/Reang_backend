@extends('admin.partials.app')

@section('content')
<div class="container">
    <h2>Edit Akun</h2>
    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $account->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" 
                   value="{{ old('email', $account->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Password (kosongkan jika tidak ingin diubah)</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
            </div>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">👁</button>
            </div>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="superadmin" {{ old('role', $account->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admindinas" {{ old('role', $account->role) == 'admindinas' ? 'selected' : '' }}>Admin Dinas</option>
            </select>
        </div>

        <div class="mb-3" id="dinas-wrapper" style="display: none;">
            <label>Dinas</label>
            <select name="dinas" class="form-control">
                <option value="">-- Pilih Dinas --</option>
                <option value="kesehatan" {{ old('dinas', $account->dinas) == 'kesehatan' ? 'selected' : '' }}>Dinas Kesehatan</option>
                <option value="pendidikan" {{ old('dinas', $account->dinas) == 'pendidikan' ? 'selected' : '' }}>Dinas Pendidikan</option>
                <option value="pariwisata" {{ old('dinas', $account->dinas) == 'pariwisata' ? 'selected' : '' }}>Dinas Pariwisata</option>
                <option value="perdagangan" {{ old('dinas', $account->dinas) == 'perdagangan' ? 'selected' : '' }}>Dinas Perdagangan</option>
                <!-- tambahkan sesuai kebutuhan -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

// tampilkan field dinas kalau role = admindinas
function toggleDinasField() {
    const role = document.getElementById('role').value;
    const dinasWrapper = document.getElementById('dinas-wrapper');
    dinasWrapper.style.display = role === 'admindinas' ? 'block' : 'none';
}

// jalankan saat load & saat role berubah
document.getElementById('role').addEventListener('change', toggleDinasField);
toggleDinasField();
</script>
@endsection
