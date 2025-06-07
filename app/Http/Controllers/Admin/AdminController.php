<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KomikIndex as Komik;
use App\Models\Chapter;
use App\Models\User;
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
        return view('admin.comics.index', compact('comics'));
    }

    public function createComic()
    {
        $genres = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 
            'Horror', 'Romance', 'Sci-Fi', 'Slice of Life', 'Sports',
            'Supernatural', 'Thriller', 'Mystery', 'Historical'
        ];
        
        $languages = ['Indonesia', 'English', 'Japanese', 'Korean', 'Chinese'];
        
        return view('admin.comics.create', compact('genres', 'languages'));
    }

    public function storeComic(Request $request)
    {
        $request->validate([
        'judul' => 'required|string|max:255|unique:komiks,judul',
        'cover' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'description' => 'required|string|min:10',
        'author' => 'required|string|max:255',
        'status' => 'required|string|max:50',
        'language' => 'required|string|max:50',
        'genre' => 'required|string|max:100',  // Tambahkan validasi genre
        'release_year' => 'required|integer|min:1900|max:' . date('Y'),
        
        // Validasi chapter
        'chapter_number' => 'required|integer|min:1',
        'chapter_title' => 'nullable|string|max:255',
        'chapter_pages.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
    ]);

        try {
            \DB::beginTransaction();

            // Upload cover
           $coverPath = $request->file('cover')->store('covers', 'public');

        // Buat komik
        $comic = Komik::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'cover' => $coverPath,
            'description' => $request->description,
            'author' => $request->author,
            'status' => $request->status,
            'language' => $request->language,
            'genre' => $request->genre,  // Tambahkan ini
            'release_year' => $request->release_year,
            'rating' => 0,
            'chapter' => 1,
            'Favorite' => 0,
            'views' => 0,
        ]);

        // ... rest of the code
    

            // Upload halaman chapter
            $chapterPages = [];
            if ($request->hasFile('chapter_pages')) {
                foreach ($request->file('chapter_pages') as $index => $page) {
                    $pagePath = $page->store("chapters/{$comic->id}/{$request->chapter_number}", 'public');
                    $chapterPages[] = $pagePath;
                }
            }

            // Buat chapter
            Chapter::create([
                'komik_id' => $comic->id,
                'chapter_number' => $request->chapter_number,
                'title' => $request->chapter_title,
                'pages' => $chapterPages,
                'views' => 0,
            ]);

            \DB::commit();

            return redirect()->route('admin.comics')->with('success', 'Komik dan chapter berhasil ditambahkan!');

        } catch (\Exception $e) {
            \DB::rollback();
            
            // Hapus file yang sudah diupload jika ada error
            if (isset($coverPath) && Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }
            
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

    public function showComic($id)
    {
        $komik = Komik::with('chapters')->findOrFail($id);
        return view('admin.comics.show', compact('komik'));
    }

    public function editComic($id)
    {
        $komik = Komik::findOrFail($id);
        $genres = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 
            'Horror', 'Romance', 'Sci-Fi', 'Slice of Life', 'Sports',
            'Supernatural', 'Thriller', 'Mystery', 'Historical'
        ];
        
        $languages = ['Indonesia', 'English', 'Japanese', 'Korean', 'Chinese'];
        
        return view('admin.comics.edit', compact('komik', 'genres', 'languages'));
    }

    public function updateComic(Request $request, $id)
    {
        $komik = Komik::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255|unique:komiks,judul,' . $id,
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'required|string|min:10',
            'author' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'language' => 'required|string|max:50',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $updateData = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'description' => $request->description,
            'author' => $request->author,
            'status' => $request->status,
            'language' => $request->language,
            'release_year' => $request->release_year,
        ];

        // Update cover jika ada file baru
        if ($request->hasFile('cover')) {
            // Hapus cover lama
            if ($komik->cover && Storage::disk('public')->exists($komik->cover)) {
                Storage::disk('public')->delete($komik->cover);
            }
            
            $updateData['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $komik->update($updateData);

        return redirect()->route('admin.comics')->with('success', 'Komik berhasil diupdate!');
    }

    public function deleteComic($id)
    {
        $comic = Komik::findOrFail($id);
        
        try {
            \DB::beginTransaction();

            // Hapus semua file terkait
            if ($comic->cover && Storage::disk('public')->exists($comic->cover)) {
                Storage::disk('public')->delete($comic->cover);
            }

            // Hapus semua halaman chapter
            foreach ($comic->chapters as $chapter) {
                if ($chapter->pages) {
                    foreach ($chapter->pages as $pagePath) {
                        if (Storage::disk('public')->exists($pagePath)) {
                            Storage::disk('public')->delete($pagePath);
                        }
                    }
                }
            }

            // Hapus folder komik
           Storage::disk('public')->deleteDirectory("chapters/{$comic->id}");

            // Hapus dari database
            $comic->delete();

            \DB::commit();

            return redirect()->route('admin.comics')->with('success', 'Komik berhasil dihapus!');

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Chapter Management
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
            // Upload halaman chapter
            $chapterPages = [];
            if ($request->hasFile('chapter_pages')) {
                foreach ($request->file('chapter_pages') as $index => $page) {
                    $pagePath = $page->store("chapters/{$comicId}/{$request->chapter_number}", 'public');
                    $chapterPages[] = $pagePath;
                }
            }

            // Buat chapter
            Chapter::create([
                'komik_id' => $comicId,
                'chapter_number' => $request->chapter_number,
                'title' => $request->chapter_title,
                'pages' => $chapterPages,
                'views' => 0,
            ]);

            // Update jumlah chapter di komik
            $komik->update([
                'chapter' => $komik->chapters()->count()
            ]);

            return redirect()->route('admin.comics.show', $comicId)->with('success', 'Chapter berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Hapus file yang sudah diupload jika ada error
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
            // Hapus semua halaman chapter
            if ($chapter->pages) {
                foreach ($chapter->pages as $pagePath) {
                    if (Storage::disk('public')->exists($pagePath)) {
                        Storage::disk('public')->delete($pagePath);
                    }
                }
            }

            // Hapus folder chapter
            Storage::disk('public')->deleteDirectory("chapters/{$comicId}/{$chapter->chapter_number}");

            $chapter->delete();

            // Update jumlah chapter di komik
            $comic->update([
                'chapter' => $comic->chapters()->count()
            ]);

            return back()->with('success', 'Chapter berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // User Management
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
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
}