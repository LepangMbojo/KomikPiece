<?php
// app/Http/Controllers/Admin/AdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KomikIndex as Komik;
use App\Models\Chapter;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;

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
        $genres = Genre::orderBy('name', 'asc')->get();
        
        $languages = ['Indonesia', 'English', 'Japanese', 'Korean', 'Chinese'];
        
        return view('admin.comics.create', compact('genres', 'languages'));
    }

    public function storeComic(Request $request)
{
    // 1. Validasi (Sudah bagus, hanya perlu memastikan 'genres.*' ada)
    $validatedData = $request->validate([
        'judul' => 'required|string|max:255|unique:komiks,judul',
        'cover' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'description' => 'required|string|min:10',
        'author' => 'required|string|max:255',
        'status' => 'required|string',
       'language' => 'required|string|max:50',         // <-- TAMBAHKAN VALIDASI
        'rating' => 'nullable|numeric|min:0|max:10', // <-- TAMBAHKAN VALIDASI
        'genres' => 'nullable|array', // Validasi bahwa 'genres' adalah array
        'genres.*' => 'exists:genres,id', // Validasi setiap ID genre ada di tabel genres


        // Validasi chapter pertama
        'chapter_number' => 'required|numeric|min:0',
        'chapter_title' => 'nullable|string|max:255',
        'chapter_pages' => 'required|array', // Pastikan chapter_pages adalah array
        'chapter_pages.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
    ]);

    $coverPath = null;
    $chapterPages = [];

    try {
        DB::beginTransaction();

        // 2. Upload cover
        $coverPath = $request->file('cover')->store('covers', 'public');

        // 3. Buat data komik utama. HAPUS baris 'genre' dari sini.
        $komik = Komik::create([
            'judul' => $validatedData['judul'],
            'cover' => $coverPath,
            'slug' => Str::slug($validatedData['judul']),
            'description' => $validatedData['description'],
            'author' => $validatedData['author'],
            'status' => $validatedData['status'],
            'language' => $validatedData['language'],   // <-- TAMBAHKAN PENYIMPANAN
            'rating' => $validatedData['rating'] ?? 0, 
            

            // Hapus 'language', 'rating', 'chapter', 'Favorite' jika tidak ada di form/validasi
            // atau berikan nilai default
            'views' => 0,
        ]);

        // =====================================================================
        // PERUBAHAN UTAMA: Lampirkan (Attach) Genre di Sini
        // =====================================================================
        if (!empty($validatedData['genres'])) {
            $komik->genres()->attach($validatedData['genres']);
        }
        // =====================================================================

        // 4. Upload halaman chapter (kode Anda sudah benar)
        foreach ($request->file('chapter_pages') as $page) {
            $pagePath = $page->store("chapters/{$komik->id}/{$validatedData['chapter_number']}", 'public');
            $chapterPages[] = $pagePath;
        }

        // 5. Buat chapter pertama (kode Anda sudah benar)
        $komik->chapters()->create([
            'chapter_number' => $validatedData['chapter_number'],
            'title' => $validatedData['chapter_title'],
            'pages' => $chapterPages,
        ]);

        DB::commit();

        return redirect()->route('admin.comics')->with('success', 'Komik dan chapter pertama berhasil ditambahkan!');

    } catch (\Exception $e) {
        DB::rollback();
        
        // Hapus file yang sudah diupload jika ada error (kode Anda sudah benar)
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
        // dd($request->all());
        // 1. Validasi Data
        // Kita tambahkan validasi untuk 'genres' di sini
        $validatedData = $request->validate([
            // unique rule harus mengabaikan ID dari komik yang sedang diedit
            'judul' => 'required|string|max:255|unique:komiks,judul,' . $id,
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'description' => 'required|string|min:10',
            'author' => 'required|string|max:255',
            'status' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'language' => 'required|string|max:50',         // <-- TAMBAHKAN VALIDASI
            'rating' => 'nullable|numeric|min:0|max:10',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id'
        ]);

        $komik = Komik::findOrFail($id);

        // 2. Ambil semua data yang sudah divalidasi, KECUALI 'genres' dan 'cover'
        // karena akan kita proses secara terpisah.
        $updateData = $request->except(['_token', '_method', 'cover', 'genres']);
        
        // Tambahkan slug secara manual
        $updateData['slug'] = Str::slug($request->judul);


        // 3. Update cover jika ada file baru (logika Anda sudah benar)
        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if ($komik->cover && Storage::disk('public')->exists($komik->cover)) {
                Storage::disk('public')->delete($komik->cover);
            }
            // Simpan cover baru dan tambahkan path-nya ke data update
            $updateData['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // 4. Lakukan update data utama komik
        $komik->update($updateData);

        // =====================================================================
        // PERUBAHAN UTAMA: Sinkronisasi (Sync) Genre di Sini
        // =====================================================================
        // Gunakan sync() untuk memperbarui relasi genre di tabel pivot.
        // `input('genres', [])` akan mengirim array kosong jika tidak ada genre yang dipilih,
        // yang akan membuat sync() menghapus semua genre dari komik ini.
        $komik->genres()->sync($request->input('genres', []));
        // =====================================================================

        return redirect()->route('admin.comics.show', $komik->id)->with('success', 'Komik berhasil diupdate!');
    }



    public function deleteComic($id)
    {
        $comic = Komik::findOrFail($id);
        
        try {
            DB::beginTransaction();

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

            DB::commit();

            return redirect()->route('admin.comics')->with('success', 'Komik berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollback();
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
            'chapter_title' => 'required|string|max:255',
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