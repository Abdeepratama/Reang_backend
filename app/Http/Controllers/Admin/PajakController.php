<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PajakController extends Controller
{
    public function dashboard()
    {
        return view('admin.pajak.index');
    }
}
