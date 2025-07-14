<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KerjaController extends Controller
{
    public function dashboard()
    {
        return view('admin.Kerja.index');
    }
}
