<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomikIndex;
use App\Models\Genre;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
  /**
     * Menampilkan halaman daftar semua genre yang tersedia untuk dipilih pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua genre, diurutkan berdasarkan nama.
        // withCount('komiks') akan menambahkan properti 'komiks_count' 
        // pada setiap genre, ini efisien untuk menampilkan jumlah komik.
        $genres = Genre::withCount('komiks')->orderBy('name', 'asc')->get();

        // Mengembalikan view 'index' yang ada di folder 'genres'.
        return view('komik.genre', compact('genres'));
    }

    /**
     * Menampilkan daftar komik berdasarkan genre yang dipilih pengguna.
     * Kita akan menggunakan 'slug' dari genre untuk URL yang lebih baik (SEO-friendly).
     *
     * @param  \App\Models\Genre  $genre  // Ini adalah Route-Model Binding
     * @return \Illuminate\View\View
     */
    public function show(Genre $genre)
    {
        // Laravel secara otomatis akan menemukan genre berdasarkan slug dari URL.
        
        // Mengambil komik-komik yang berhubungan dengan genre ini.
        // Gunakan paginate() agar halaman tidak berat jika komiknya banyak.
        $komiks = $genre->komiks()->latest()->paginate(16); // Menampilkan 16 komik per halaman

        // Mengembalikan view 'show' yang ada di folder 'genres'.
        return view('komik.genre', compact('genre', 'komiks'));
    }
}
