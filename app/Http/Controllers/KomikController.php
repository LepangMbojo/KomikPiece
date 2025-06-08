<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomikIndex;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\Comments;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; 


class KomikController extends Controller
{
    // Di dalam file: app/Http/Controllers/KomikController.php

public function index()
{
   $komiks = \App\Models\KomikIndex::latest()->paginate(12);

    // 2. Ambil data komik yang berpotensi populer dari DB
    $potentiallyPopular = \App\Models\KomikIndex::query()
        ->withCount('favoredByUsers') // Tetap hitung jumlah favorit
        ->orderByDesc('views') // Lakukan pra-filter awal berdasarkan views
        ->limit(100) // Ambil 100 komik dengan views terbanyak
        ->get();

    // 3. Hitung skor dan urutkan menggunakan Collection di PHP
    $popularKomiks = $potentiallyPopular->sortByDesc(function ($komik) {
        // Rumus yang sama, tapi dihitung di PHP
        return $komik->views;
    })->take(5); // Ambil 6 teratas setelah diurutkan

    // 4. Kirim kedua data ke view
    return view('komik.index', compact('komiks', 'popularKomiks'));
}


    // Method baru untuk dashboard
  // Di dalam KomikController.php

public function dashboard()
{
    // 1. Ambil komik terbaru untuk dashboard
    $latestKomiks = \App\Models\KomikIndex::latest()->take(6)->get();

    // 2. Logika yang sama untuk mengambil data populer
    $potentiallyPopular = \App\Models\KomikIndex::query()
        ->withCount('favoredByUsers')
        ->orderByDesc('views')
        ->limit(100)
        ->get();

    $popularKomiks = $potentiallyPopular->sortByDesc(function ($komik) {
        return $komik->views;
    })->take(5); // Ambil 8 teratas untuk dashboard

    // 3. Siapkan data lain untuk dashboard
    $user = auth()->user();
    
    // ===================================================================
    // KEMBALIKAN VARIABEL INI UNTUK MENCEGAH ERROR DI VIEW
    // TODO: Nantinya, ganti array kosong ini dengan query database asli saat fiturnya sudah dibuat.
    $bookmarkedComics = []; 
    $recentlyRead = [];
    // ===================================================================
    
    // 4. Kirim SEMUA variabel yang dibutuhkan oleh view
    return view('komik.index', [ // Pastikan nama view sudah benar ('index' atau 'komik.index')
        'isDashboard'      => true,
        'komiks'           => $latestKomiks,
        'popularKomiks'    => $popularKomiks,
        'user'             => $user,
        'bookmarkedComics' => $bookmarkedComics, // <-- Kirim variabel ini
        'recentlyRead'     => $recentlyRead,   // <-- Kirim variabel ini
    ]);
}
    
   public function show($id)
{
    try {
        $komik = KomikIndex::with(['chapters', 'comments.user'])->findOrFail($id);

        // Increment views
        $komik->increment('views');

        // Get related komiks (nama variabel diperbaiki menjadi camelCase)
        $relatedkomiks = KomikIndex::where('id', '!=', $id)
                                     ->inRandomOrder() // Dibuat random agar lebih bervariasi
                                     ->limit(6)
                                     ->get();
// dd($komik->comments);
// dd($komik->toArray());
    // dd(get_class_methods($komik));



        // ===================================================================
        // LOGIKA UNTUK MENGECEK STATUS FAVORIT (DITAMBAHKAN DI SINI)
        // ===================================================================
        $isFavorited = false; // Default-nya false
        if (Auth::check()) {
            // Jika user login, cek apakah komik ini ada di dalam relasi 'favorites' milik user
            $isFavorited = Auth::user()->favorites()->where('komik_id', $komik->id)->exists();
        }
        // ===================================================================

        // Kirim semua variabel yang dibutuhkan ke view, termasuk 'isFavorited'
        return view('komik.show', compact('komik', 'relatedkomiks', 'isFavorited'));

    } catch (\Exception $e) {
        Log::error('Comic show error: ' . $e->getMessage());
        return redirect()->route('index')->with('error', 'Comic not found');
    }
}


    public function search(Request $request)
    {
        $query = $request->get('q');
        $komiks = KomikIndex::where('judul', 'LIKE', "%{$query}%")
                      ->orWhere('author', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%")
                      ->paginate(12);
        return view('komik.search', compact('komiks', 'query'));
    }


    public function chapter($id, $chapterNumber)
    {
        $komik = KomikIndex::findOrFail($id);
        $chapter = Chapter::where('komik_id', $id)
                         ->where('chapter_number', $chapterNumber)
                         ->firstOrFail();
        
        // Increment views
        $chapter->increment('views');
        $komik->increment('views');
        
        return view('komik.chapter', compact('komik', 'chapter'));
    }
    
    // Anda bisa menggunakan Route Model Binding untuk kode yang lebih bersih
    // Pastikan di routes/web.php Anda menggunakan {komik} bukan {id}
    // Contoh: Route::post('/komik/{komik}/comments', ...)

    public function storeComment(Request $request, \App\Models\KomikIndex $komik)
    {
    $request->validate([
        'content' => 'required|string|min:3|max:1000'
    ]);

    // Gunakan relasi untuk membuat komentar baru.
    // 'komik_id' akan diisi secara otomatis oleh Laravel.
    // Anda tidak perlu lagi mendaftarkan 'komik_id' di $fillable pada model Comments.
    $komik->comments()->create([
        'user_id' => auth()->id(), // 'user_id' dan 'content' tetap perlu ada di $fillable
        'content' => $request->content
    ]);

    return back()->with('success', 'Comment posted successfully!');
}

  public function showChapter($id, $chapterNumber)
    {
        try {
            $komik = KomikIndex::findOrFail($id);
            $chapter = Chapter::where('komik_id', $id)
                              ->where('chapter_number', $chapterNumber)
                              ->firstOrFail();

            // Debug log
            Log::info('Chapter data: ', [ // Log akan dikenali
                'komik_id' => $komik->id,
                'chapter_id' => $chapter->id,
                'pages' => $chapter->pages,
                'pages_url' => $chapter->pages_url, // Pastikan properti ini ada
                'storage_files' => Storage::disk('public')->files('chapters/' . $id . '/' . $chapterNumber) // Storage akan dikenali
            ]);

            $chapter->increment('views');

            return view('komik.chapter', compact('komik', 'chapter'));

        } catch (\Exception $e) {
            Log::error('Chapter error: ' . $e->getMessage()); // Log akan dikenali
            return redirect()->route('komik.show', $id)->with('error', 'Chapter not found');
        }
    }

}