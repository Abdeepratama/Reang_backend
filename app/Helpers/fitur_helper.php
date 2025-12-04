<?php

use App\Models\Kategori;

if (! function_exists('fitur_list')) {
    /**
     * Daftar fitur utama aplikasi.
     *
     * @return array
     */
    function fitur_list()
    {
        return [
            'event agama',
            'info plesir',
            'info kerja',
            'info perizinan',
            'info renbang',
            'info kesehatan',
            'lokasi ibadah',
            'lokasi kesehatan',
            'lokasi pasar',
            'lokasi olahraga',
            'lokasi sekolah',
            
        ];
    }
}

if (! function_exists('kategori_by_fitur')) {
    /**
     * Ambil kategori berdasarkan fitur tertentu.
     *
     * @param string $fitur
     * @return \Illuminate\Support\Collection
     */
    function kategori_by_fitur($fitur)
    {
        return Kategori::where('fitur', $fitur)
            ->orderBy('nama')
            ->get();
    }
}
