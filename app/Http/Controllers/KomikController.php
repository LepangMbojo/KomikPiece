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

public function index()
{
    // Cek apakah ada pengguna yang sedang login
    if (auth()->check()) {
        // --- LOGIKA UNTUK DASHBOARD ---
        
        // MENGGUNAKAN PAGINATE DI SINI SESUAI PERMINTAAN ANDA
        $latestKomiks = KomikIndex::withMax('chapters', 'chapter_number')
                                              ->latest()
                                              ->paginate(10); // Jumlah item per halaman bisa disesuaikan

        $popularKomiks = $this->getPopularComics(5);
        $user = auth()->user();
        $bookmarkedComics = []; 
        $recentlyRead = [];
        
        return view('komik.index', [
            'isDashboard'      => true,
            'komiks'           => $latestKomiks,
            'popularKomiks'    => $popularKomiks,
            'user'             => $user,
            'bookmarkedComics' => $bookmarkedComics,
            'recentlyRead'     => $recentlyRead,
        ]);

    } else {
        // --- LOGIKA UNTUK HALAMAN UTAMA PUBLIK (SUDAH BENAR) ---
        $komiks = KomikIndex::withMax('chapters', 'chapter_number')
                                        ->latest()
                                        ->paginate(10);
        
        $popularKomiks = $this->getPopularComics(5);

        return view('komik.index', compact('komiks', 'popularKomiks'));
    }
}
    /**
     * Method pribadi untuk mengambil komik populer.
     * Hanya bisa diakses dari dalam controller ini.
     *
     * @param int $limit Jumlah komik yang ingin diambil
     * @return \Illuminate\Support\Collection
     */
    private function getPopularComics(int $limit)
{
    $potentiallyPopular = KomikIndex::query()
        // TAMBAHKAN INI untuk mengambil chapter terbaru secara efisien
        ->withMax('chapters', 'chapter_number')
        // Jika Anda masih ingin menggunakan skor favorit, withCount ini juga diperlukan 
        ->orderByDesc('views')
        ->limit(100)
        ->get();

    // Hitung skor popularitas dan urutkan di PHP
    return $potentiallyPopular->sortByDesc(function ($komik) {
        // Rumus: (jumlah views) + (jumlah favorit * 50)
        return $komik->views;
    })->take($limit);
}
     
   public function show($id)
{
    try {
        $komik = KomikIndex::with(['chapters', 'comments.user','genres'])->findOrFail($id);

        // Increment views
        $komik->increment('views');

        // Get related komiks (nama variabel diperbaiki menjadi camelCase)
       $relatedkomiks = KomikIndex::where('id', '!=', $id)
                              // Tambahkan withCount untuk data yang dibutuhkan di kartu komik
                            ->withCount(['chapters', 'comments'])
                                          ->inRandomOrder()
                                          ->limit(6)
                                          ->get();
// dd($komik->comments);
// dd($komik->toArray());
    // dd(get_class_methods($komik));
        //    dd($komik->toArray());


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
                      ->paginate(10);
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