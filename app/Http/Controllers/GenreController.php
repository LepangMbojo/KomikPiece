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

        
        $komiks = $genre->komiks()->latest()->paginate(5); 

        
        return view('genre.show', compact('genre', 'komiks'));
    }
}