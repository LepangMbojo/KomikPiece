<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Menampilkan halaman daftar semua genre yang tersedia.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jenis = Genre::withCount('komiks')->orderBy('name', 'asc')->get();

        return view('genre.home', compact('jenis'));
    }

    /**
     * Menampilkan daftar komik berdasarkan genre yang dipilih.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {

        $genre = Genre::where('slug', $slug)->firstOrFail();

        // 2. Ambil semua komik yang terhubung dengan genre ini, dengan paginasi.
        $komiks = $genre->komiks()->latest()->paginate(12); // Menampilkan 12 komik per halaman

        // 3. Tampilkan view dan kirim data genre beserta daftar komiknya.
        // Pastikan Anda memiliki file view di resources/views/genre/show.blade.php
        return view('genre.show', compact('genre', 'komiks'));
    }
}