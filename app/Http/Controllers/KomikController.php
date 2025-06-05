<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomikIndex;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\Comments;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; 


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
        try {
            $komik = KomikIndex::with(['chapters', 'comments.user'])->findOrFail($id);

            // Debug log
            Log::info('Comic data: ', [ // Sekarang Log akan dikenali
                'id' => $komik->id,
                'judul' => $komik->judul,
                'cover' => $komik->cover,
                'cover_image' => $komik->cover_image, // Pastikan properti ini ada di model KomikIndex
                'cover_exists' => $komik->cover_exists, // Pastikan properti ini ada di model KomikIndex
                'storage_files' => Storage::disk('public')->files('covers') // Storage juga akan dikenali
            ]);

            // Increment views
            $komik->increment('views');

            // Get related komiks
            $relatedkomiks = KomikIndex::where('id', '!=', $id)
                                      ->limit(6)
                                      ->get();

            return view('komik.show', compact('komik', 'relatedkomiks'));

        } catch (\Exception $e) {
            Log::error('Comic show error: ' . $e->getMessage()); // Log akan dikenali
            return redirect()->route('komik.index')->with('error', 'Comic not found');
        }
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

    $komik = KomikIndex::findOrFail($id);

    Comments::create([
        'user_id' => auth()->id(),
        'komik_id' => $komik->id,
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