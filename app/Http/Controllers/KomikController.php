<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomikIndex;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\Comments;

class KomikController extends Controller
{
    public function index()
    {
        $komiks = KomikIndex::latest()->paginate(12);
        return view('komik.index', compact('komiks'));
    }

    // Method baru untuk dashboard
    public function dashboard()
    {
        $komiks = KomikIndex::orderBy('created_at', 'desc')->paginate(10);
        $popularComics = KomikIndex::orderBy('views', 'desc')->take(8)->get();
        
        // Anda bisa menambahkan data khusus untuk user yang login
        $user = auth()->user();
        $bookmarkedComics = []; // Komik yang di-bookmark user
        $recentlyRead = []; // Komik yang baru dibaca user
        
        return view('dashboard', compact('komiks', 'user', 'bookmarkedComics', 'recentlyRead', 'popularComics'));
    }

    public function show($id)
{
    $komik = KomikIndex::with('chapters')->findOrFail($id);
    
    // Debug: Periksa data comic
    \Log::info('Comic data:', [
        'id' => $komik->id,
        'judul' => $komik->judul,
        'cover' => $komik->cover,
        'genre' => $komik->genre, // Tambahkan ini untuk debug
        'cover_exists' => \Storage::disk('public')->exists($komik->cover ?? '')
    ]);

    $relatedComics = KomikIndex::where('genre', $komik->genre)
                        ->where('id', '!=', $komik->id)
                        ->take(6)
                        ->get();

    return view('komik.show', compact('komik', 'relatedComics'));
}

    public function search(Request $request)
    {
        $query = $request->get('q');
        $komiks = KomikIndex::where('judul', 'LIKE', "%{$query}%")
                      ->orWhere('author', 'LIKE', "%{$query}%")
                      ->orWhere('deskripsi', 'LIKE', "%{$query}%")
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
    
    public function storeComment(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string|min:3|max:1000'
    ]);

    $comic = KomikIndex::findOrFail($id);

    Comments::create([
        'user_id' => auth()->id(),
        'komik_id' => $comic->id,
        'content' => $request->content
    ]);

    return back()->with('success', 'Comment posted successfully!');
}

   public function showChapter($id, $chapter)
{
    \Log::info('Chapter request:', [
        'komik_id' => $id,
        'chapter_number' => $chapter,
        'url' => request()->url(),
        'referer' => request()->header('referer')
    ]);
    
    $komik = KomikIndex::with('chapters')->findOrFail($id);
    $currentChapter = $komik->chapters()
                           ->where('chapter_number', $chapter)
                           ->firstOrFail();
    
    $chapter = $currentChapter;
    return view('komik.chapter', compact('komik', 'chapter'));

}
}