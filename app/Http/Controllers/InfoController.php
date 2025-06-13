<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        return view('info.index'); // Merender view info/about.blade.php
    }

    // Jika Anda punya halaman kontak, bisa tambahkan:
    // public function contact()
    // {
    //     return view('info.contact');
    // }
}