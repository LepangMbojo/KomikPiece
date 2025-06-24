<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomikIndex;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
   public function index()
    {
       $favoriteKomiks = Auth::user()->favorites()
                                ->withMax('chapters', 'chapter_number') 
                                ->orderBy('pivot_created_at', 'asc')
                                ->paginate(12);

        return view('komik.Favorite', compact('favoriteKomiks'));
    }

    public function add(KomikIndex $komik)
    {
        Auth::user()->favorites()->attach($komik->id);
        return back()->with('success', 'Komik berhasil ditambahkan ke favorit!');
    }

    public function remove(KomikIndex $komik)
    {
        Auth::user()->favorites()->detach($komik->id);
        return back()->with('success', 'Komik berhasil dihapus dari favorit.');
    }
}
