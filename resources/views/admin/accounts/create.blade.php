@extends('admin.partials.app')

@section('content')
<div class="container">
    <h2>Tambah Akun</h2>
    <form action="{{ route('admin.accounts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
            </div>
        </div>

        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">👁</button>
            </div>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="superadmin">Super Admin</option>
                <option value="admindinas">Admin Dinas</option>
                <option value="dokter">Dokter</option>
            </select>
        </div>

        <div class="mb-3" id="dinas-wrapper" style="display: none;">
            <label>Dinas</label>
            <select name="dinas" class="form-control">
                <option value="">-- Pilih Dinas --</option>
                <option value="kesehatan">Dinas Kesehatan</option>
                <option value="pendidikan">Dinas Pendidikan</option>
                <option value="perpajakan">Dinas Perpajakan</option>
                <option value="keagamaan">Dinas Keagamaan</option>
                <option value="perizinan">Dinas Perizinan</option>
                <option value="kerja">Dinas Tenaga Kerja</option>
                <option value="perdagangan">Dinas Perdagangan</option>
                <option value="pariwisata">Dinas Periwisata dan Kebudayaan</option>
                <option value="pembangunan">Dinas Pembangunan</option>
                <option value="perdagangan">Dinas Perpajakan</option>
                <option value="perpajakan">Dinas Kependudukan</option>
                <!-- tambahkan sesuai kebutuhan -->
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

// tampilkan field dinas hanya kalau pilih role = admindinas
document.getElementById('role').addEventListener('change', function () {
    const dinasWrapper = document.getElementById('dinas-wrapper');
    dinasWrapper.style.display = this.value === 'admindinas' ? 'block' : 'none';
});
</script>
@endsection
