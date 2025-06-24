<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KomikIndex as Komik;
use App\Models\Chapter;
use App\Models\User;
use App\Models\Genre;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalComics = Komik::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalChapters = Chapter::count();
        $recentComics = Komik::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalComics', 
            'totalUsers', 
            'totalAdmins',
            'totalChapters',
            'recentComics', 
            'recentUsers'
        ));
    }

    public function comics()
    {
        $comics = Komik::withCount('chapters')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comics.index', compact('comics') );
    }

    // berfungsi sebagai form untuk pilihan tetap yang sudah ada
    public function createComic() 
    {
        $genres = Genre::orderBy('name', 'asc')->get();
        
        $languages = ['Indonesia', 'English', 'Japanese', 'Korean', 'Chinese'];
        
        return view('admin.comics.create', compact('genres', 'languages'));
    }

    

    public function storeComic(Request $request)
    {
  
    $validatedData = $request->validate([
        'judul' => 'required|string|max:255|unique:komiks,judul',
        'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'description' => 'nullable|string',
        'author' => 'nullable|string|max:255',
        'status' => 'nullable|string',
        'language' => 'required|string|max:50',         
        'rating' => 'nullable|numeric|min:0|max:5', 
        'genres' => 'nullable|array', 
        'genres.*' => 'exists:genres,id', 

        'chapter_number' => 'required|numeric|min:0',
        'chapter_title' => 'nullable|string|max:255',
        'chapter_pages' => 'nullable|array', 
        'chapter_pages.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
    ]);



    try {

        $coverPath = $request->file('cover')->store('covers', 'public');

        $komik = Komik::create([
            'judul' => $validatedData['judul'],
            'cover' => $coverPath,
            'description' => $validatedData['description'],
            'author' => $validatedData['author'],
            'status' => $validatedData['status'],
            'language' => $validatedData['language'],  
            'rating' => $validatedData['rating'] ?? 0, 
            'views' => 0,
        ]);

        if (!empty($validatedData['genres'])) {
            $komik->genres()->attach($validatedData['genres']);
        }

            $chapterPages = [];
        if ($request->hasFile('chapter_pages')) {

            $files = $request->file('chapter_pages');

            // Urutkan array file berdasarkan nama asli file menggunakan natural order sorting
            usort($files, function ($a, $b) {
                return strnatcmp($a->getClientOriginalName(), $b->getClientOriginalName());
            });

            // Sekarang lakukan perulangan pada file yang SUDAH TERURUT
            foreach ($files as $page) {
                $pagePath = $page->store("chapters/{$komik->id}/{$validatedData['chapter_number']}", 'public');
                $chapterPages[] = $pagePath;
            }
        }


        $komik->chapters()->create([
            'chapter_number' => $validatedData['chapter_number'],
            'title' => $validatedData['chapter_title'],
            'pages' => $chapterPages,
        ]);


        return redirect()->route('admin.comics')->with('success', 'Komik dan chapter pertama berhasil ditambahkan!');

    } catch (\Exception $e) {

        if ($coverPath && Storage::disk('public')->exists($coverPath)) {
            Storage::disk('public')->delete($coverPath);
        }
        if (!empty($chapterPages)) {
            Storage::disk('public')->deleteDirectory("chapters/{$komik->id}/{$request->chapter_number}");
        }

        return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    }

    public function showComic($id)
    {
        $komik = Komik::with('chapters')->findOrFail($id);
        return view('admin.comics.show', compact('komik'));
    }

    public function editComic($id)
    {
        $komik = Komik::findOrFail($id);

        $genres = Genre::orderBy('name', 'asc')->get();
        
        $languages = ['Indonesia', 'English', 'Japanese', 'Korean', 'Chinese'];
        
        return view('admin.comics.edit', compact('komik', 'genres', 'languages'));
    }

    public function updateComic(Request $request, $id)
    {

        $validatedData = $request->validate([
            'judul' => 'required|string|max:255|unique:komiks,judul,' . $id,
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'required|string|min:10',
            'author' => 'required|string|max:255',
            'status' => 'required|string',  
            'rating' => 'nullable|numeric|min:0|max:10',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id'
        ]);

        $komik = Komik::findOrFail($id);

        $updateData = $request->except(['_token', '_method', 'cover', 'genres']);
        

        if ($request->hasFile('cover')) {
            if ($komik->cover && Storage::disk('public')->exists($komik->cover)) {
                Storage::disk('public')->delete($komik->cover);
            }
            $updateData['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $komik->update($updateData);

        $komik->genres()->sync($request->input('genres', []));

        return redirect()->route('admin.comics.show', $komik->id)->with('success', 'Komik berhasil diupdate!');
    }



    public function deleteComic($id)
    {
        $comic = Komik::findOrFail($id);
        
        try {

            if ($comic->cover && Storage::disk('public')->exists($comic->cover)) {
                Storage::disk('public')->delete($comic->cover);
            }

            foreach ($comic->chapters as $chapter) {
                if ($chapter->pages) {
                    foreach ($chapter->pages as $pagePath) {
                        if (Storage::disk('public')->exists($pagePath)) {
                            Storage::disk('public')->delete($pagePath);
                        }
                    }
                }
            }

        Storage::disk('public')->deleteDirectory("chapters/{$comic->id}");

            $comic->delete();


            return redirect()->route('admin.comics')->with('success', 'Komik berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function addChapter($comicId)
    {
        $komik = Komik::findOrFail($comicId);
        $lastChapter = $komik->chapters()->orderBy('chapter_number', 'desc')->first();
        $nextChapterNumber = $lastChapter ? $lastChapter->chapter_number + 1 : 1;
        
        return view('admin.comics.add-chapter', compact('komik', 'nextChapterNumber'));
    }

    public function storeChapter(Request $request, $comicId)
    {
        $komik = Komik::findOrFail($comicId);
        
        $request->validate([
            'chapter_number' => 'required|integer|min:1|unique:chapters,chapter_number,NULL,id,komik_id,' . $comicId,
            'chapter_title' => 'nullable|string|max:255',
            'chapter_pages.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        try {
    $chapterPages = [];
if ($request->hasFile('chapter_pages')) {
    
    $files = $request->file('chapter_pages');

    
    usort($files, function ($a, $b) {
        return strnatcmp($a->getClientOriginalName(), $b->getClientOriginalName());
    });

    
    foreach ($files as $page) {
        $pagePath = $page->store("chapters/{$comicId}/{$request->chapter_number}", 'public');
        $chapterPages[] = $pagePath;
    }
}
            Chapter::create([
                'komik_id' => $comicId,
                'chapter_number' => $request->chapter_number,
                'title' => $request->chapter_title,
                'pages' => $chapterPages,
                'views' => 0,
            ]);

            $komik->update([
                'chapter' => $komik->chapters()->count()
            ]);

            return redirect()->route('admin.comics.show', $comicId)->with('success', 'Chapter berhasil ditambahkan!');

        } catch (\Exception $e) {
            if (!empty($chapterPages)) {
                foreach ($chapterPages as $pagePath) {
                    if (Storage::disk('public')->exists($pagePath)) {
                        Storage::disk('public')->delete($pagePath);
                    }
                }
            }

            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteChapter($comicId, $chapterId)
    {
        $chapter = Chapter::where('komik_id', $comicId)->findOrFail($chapterId);
        $comic = Komik::findOrFail($comicId);
        
        try {
            if ($chapter->pages) {
                foreach ($chapter->pages as $pagePath) {
                    if (Storage::disk('public')->exists($pagePath)) {
                        Storage::disk('public')->delete($pagePath);
                    }
                }
            }

            Storage::disk('public')->deleteDirectory("chapters/{$comicId}/{$chapter->chapter_number}");

            $chapter->delete();

            $comic->update([
                'chapter' => $comic->chapters()->count()
            ]);

            return back()->with('success', 'Chapter berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pengguna()
    {
        $users = User::orderBy('created_at', 'asc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function promoteUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => 'admin']);

        return redirect()->route('admin.users')->with('success', 'User berhasil dipromosikan menjadi admin!');
    }
    
    public function demoteAdmin($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak bisa mendemote diri sendiri!');
        }

        $user->update(['role' => 'user']);

        return redirect()->route('admin.users')->with('success', 'Admin berhasil diturunkan menjadi user!');
    }
    
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'is_banned' => 'required|boolean', 
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa mengubah status ban akun Anda sendiri!');
        }

        try {
            $user->update([
                'is_banned' => $request->is_banned,
            ]);

            $message = $request->is_banned ? 'User berhasil di-ban!' : 'User berhasil di-unban!';
            return redirect()->route('admin.users')->with('success', $message);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status user: ' . $e->getMessage());
        }
    }
}