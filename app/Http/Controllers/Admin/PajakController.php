<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PajakController extends Controller
{
    public function index()
    {
        // Logika menampilkan daftar data pajak
        return view('admin.pajak.index'); // pastikan view-nya juga tersedia
    }
}
