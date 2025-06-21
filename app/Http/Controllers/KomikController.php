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
    /**
     * Method pribadi untuk mengambil komik populer.
     * Hanya bisa diakses dari dalam controller ini.
     *
     * @param int $limit Jumlah komik yang ingin diambil
     * @return \Illuminate\Support\Collection
     */
    
public function index()
{
    if (auth()->check()) {

        
        $latestKomiks = KomikIndex::withMax('chapters', 'chapter_number') ->latest() ->paginate(10); 

        $popularKomiks = $this->getPopularComics(5);
        $user = auth()->user();
     
        
        return view('komik.index', [
            'isDashboard'      => true,
            'komiks'           => $latestKomiks,
            'popularKomiks'    => $popularKomiks,
            'user'             => $user,
          
        ]);

    } else {
        // --- LOGIKA UNTUK HALAMAN UTAMA PUBLIK (SUDAH BENAR) ---
        $komiks = KomikIndex::withMax('chapters', 'chapter_number')  ->latest()  ->paginate(10);
        
        $popularKomiks = $this->getPopularComics(5);

        return view('komik.index', compact('komiks', 'popularKomiks'));
    }
}
    private function getPopularComics(int $limit)
{
    $potentiallyPopular = KomikIndex::query()
        ->withMax('chapters', 'chapter_number')
        ->orderByDesc('views')
        ->limit(100)
        ->get();

   
    return $potentiallyPopular->sortByDesc(function ($komik) {
        return $komik->views;
    })->take($limit);
}
     
   public function show($id)
{
    try {
        $komik = KomikIndex::with(['chapters', 'comments.user','genres'])->findOrFail($id);

     
        $komik->increment('views');


        $isFavorited = false; 
        if (Auth::check()) {
            $isFavorited = Auth::user()->favorites()->where('komik_id', $komik->id)->exists();
        }
       
        return view('komik.show', compact('komik', 'isFavorited'));

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
        $chapter = Chapter::where('komik_id', $id)->where('chapter_number', $chapterNumber)->firstOrFail();
        
        $chapter->increment('views');
        $komik->increment('views');
        
        return view('komik.chapter', compact('komik', 'chapter'));
    }
    
    public function storeComment(Request $request, \App\Models\KomikIndex $komik)
    {
    $request->validate([
        'content' => 'required|string|min:3|max:1000'
    ]);

   
    $komik->comments()->create([
        'user_id' => auth()->id(), 
        'content' => $request->content
    ]);

    return back()->with('success', 'Comment posted successfully!');
}

  public function showChapter($id, $chapterNumber)
    {
        try {
            $komik = KomikIndex::findOrFail($id);
            $chapter = Chapter::where('komik_id', $id)->where('chapter_number', $chapterNumber) ->firstOrFail();

            $previousChapter = $komik->chapters() ->where('chapter_number', '<', $chapter->chapter_number)->orderBy('chapter_number', 'desc')->first();

            $nextChapter = $komik->chapters()->where('chapter_number', '>', $chapter->chapter_number)->orderBy('chapter_number', 'asc')->first();


            $chapter->increment('views');

            return view('komik.chapter', compact('komik', 'chapter','previousChapter','nextChapter'));

        } catch (\Exception $e) {
            Log::error('Chapter error: ' . $e->getMessage()); 
            return redirect()->route('komik.show', $id)->with('error', 'Chapter not found');
        }
    }

}