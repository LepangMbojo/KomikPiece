<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Admin\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute-rute di sini dikelompokkan untuk kemudahan pengelolaan.
| 1. Rute Publik: Bisa diakses siapa saja.
| 2. Rute Terautentikasi: Hanya untuk user yang sudah login.
| 3. Rute Admin: Hanya untuk user dengan role admin.
|
*/

// ===================================================================
// 1. RUTE PUBLIK (Dapat diakses oleh semua pengunjung)
// ===================================================================

Route::get('/', [KomikController::class, 'index'])->name('index');
Route::get('/search', [KomikController::class, 'search'])->name('komik.search');

// Rute untuk menampilkan detail komik dan chapter
Route::get('/komik/{id}', [KomikController::class, 'show'])->name('komik.show');
Route::get('/komik/{id}/chapter/{chapter}', [KomikController::class, 'showChapter'])->name('komik.chapter');

// Rute untuk genre
Route::get('/genres', [GenreController::class, 'index'])->name('genre.index');
// Route.get('/genre/{slug}', [GenreController::class, 'show'])->name('comics.genre');

// Rute untuk memuat lebih banyak komentar (jika menggunakan AJAX/fetch)
Route::get('/komik/{komik}/comments/load-more', [CommentController::class, 'loadMore'])->name('komik.comments.load-more');


// ===================================================================
// 2. RUTE TERAUTENTIKASI (Hanya untuk user yang sudah login)
// ===================================================================

Route::middleware('auth')->group(function () {
    // Dashboard untuk user biasa
    Route::get('/dashboard', [KomikController::class, 'dashboard'])->middleware('verified')->name('dashboard');

    // Pengelolaan profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menyimpan komentar (menggunakan route model binding {komik})
    Route::post('/komik/{komik}/comments', [CommentController::class, 'store'])->name('komik.comments.store');
});


// ===================================================================
// 3. RUTE ADMIN (Hanya untuk user dengan role 'admin')
// ===================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manajemen Komik (Resourceful Routes)
    Route::get('/comics', [AdminController::class, 'comics'])->name('comics');
    Route::get('/comics/create', [AdminController::class, 'createComic'])->name('comics.create');
    Route::post('/comics', [AdminController::class, 'storeComic'])->name('comics.store');
    Route::get('/comics/{id}', [AdminController::class, 'showComic'])->name('comics.show');
    Route::get('/comics/{id}/edit', [AdminController::class, 'editComic'])->name('comics.edit');
    Route::put('/comics/{id}', [AdminController::class, 'updateComic'])->name('comics.update');
    Route::delete('/comics/{id}', [AdminController::class, 'deleteComic'])->name('comics.delete');

    // Manajemen Chapter
    Route::get('/comics/{id}/add-chapter', [AdminController::class, 'addChapter'])->name('comics.add-chapter');
    Route::post('/comics/{id}/chapters', [AdminController::class, 'storeChapter'])->name('comics.chapters.store');
    Route::delete('/comics/{comicId}/chapters/{chapterId}', [AdminController::class, 'deleteChapter'])->name('comics.chapters.delete');
    
    // Rute upload yang sebelumnya salah tempat, dipindahkan ke sini
    Route::post('/upload', [AdminController::class, 'upload'])->name('komik.upload');

    // Manajemen User
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{id}/promote', [AdminController::class, 'promoteUser'])->name('users.promote');
    Route::patch('/users/{id}/demote', [AdminController::class, 'demoteAdmin'])->name('users.demote');
});


// ===================================================================
// Rute Otentikasi Bawaan Laravel
// ===================================================================

require __DIR__.'/auth.php';