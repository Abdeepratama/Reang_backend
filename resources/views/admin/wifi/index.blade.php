@extends('admin.partials.app')

@section('title', 'Wifi-Yu')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0 p-4" style="max-width: 600px; border-radius: 20px;">

        <div class="text-center mb-3">
            <!-- Icon Palu / Development -->
            <i class="bi bi-hammer text-warning" style="font-size: 4rem;"></i>
        </div>

        <h3 class="text-center fw-bold mb-2">Sedang Dalam Pengembangan</h3>

        <p class="text-center text-muted mb-4">
            <strong style="color: #555;">
                Fitur Wifi-Yu sedang dalam tahap pembangunan,
                nantikan pembaruan menarik selanjutnya!
            </strong>
        </p>

        <div class="text-center">
            <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 1rem; border-radius: 10px;">
                <i class="bi bi-gear-wide-connected me-1"></i> Sedang Progress
            </span>
        </div>

        <div class="mt-4 text-center">
            <strong style="color: #555;">
                Terima kasih atas kesabarannya 🙏
            </strong>
        </div>

    </div>
</div>
@endsection