@extends('admin.layouts.app')

@section('title', 'Tambah Aduan Sekolah')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tambah Aduan Sekolah</h2>

    <div id="alertContainer"></div>

    <form id="aduanForm" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="jenis_laporan" class="form-label">Jenis Aduan</label>
            <input type="text" class="form-control" id="jenis_laporan" name="jenis_laporan" required>
        </div>

        <div class="mb-3">
            <label for="kategori_laporan" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="kategori_laporan" name="kategori_laporan" required>
        </div>

        <div class="mb-3">
            <label for="lokasi_laporan" class="form-label">Lokasi</label>
            <input type="text" class="form-control" id="lokasi_laporan" name="lokasi_laporan">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="bukti_laporan" class="form-label">Bukti (opsional)</label>
            <input type="file" class="form-control" id="bukti_laporan" name="bukti_laporan" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Kirim Aduan</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('aduanForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('{{ url("/api/sekolah-aduan") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                // 'Authorization': 'Bearer your_token_if_needed', 
            },
            body: formData
        });

        const result = await response.json();

        const alertContainer = document.getElementById('alertContainer');
        alertContainer.innerHTML = '';

        if (response.ok) {
            alertContainer.innerHTML = `<div class="alert alert-success">✅ ${result.message || 'Aduan berhasil dikirim!'}</div>`;
            form.reset();
        } else {
            const errors = result.errors || { message: 'Terjadi kesalahan.' };
            for (let key in errors) {
                alertContainer.innerHTML += `<div class="alert alert-danger">❌ ${errors[key]}</div>`;
            }
        }
    } catch (error) {
        console.error(error);
        document.getElementById('alertContainer').innerHTML = `<div class="alert alert-danger">❌ Gagal mengirim aduan.</div>`;
    }
});
</script>
@endsection
