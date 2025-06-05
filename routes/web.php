<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CommentController;


// Routes public
Route::get('/', [KomikController::class, 'index'])->name('index');
Route::get('/komik/{id}', [KomikController::class, 'show'])->name('komik.show');
Route::get('/search', [KomikController::class, 'search'])->name('komik.search');
Route::get('/komik/{id}/chapter/{chapter}', [KomikController::class, 'chapter'])->name('komik.chapter');

// Routes yang memerlukan authentication
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [KomikController::class, 'dashboard'])->name('dashboard');
});

// Routes khusus admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Comics management
    Route::get('/comics', [AdminController::class, 'comics'])->name('comics');
    Route::get('/comics/create', [AdminController::class, 'createComic'])->name('comics.create');
    Route::post('/comics', [AdminController::class, 'storeComic'])->name('comics.store');
    Route::get('/comics/{id}', [AdminController::class, 'showComic'])->name('comics.show');
    Route::get('/comics/{id}/edit', [AdminController::class, 'editComic'])->name('comics.edit');
    Route::put('/comics/{id}', [AdminController::class, 'updateComic'])->name('comics.update');
    Route::delete('/comics/{id}', [AdminController::class, 'deleteComic'])->name('comics.delete');
    
    // Chapter management
    Route::get('/comics/{id}/add-chapter', [AdminController::class, 'addChapter'])->name('comics.add-chapter');
    Route::post('/comics/{id}/chapters', [AdminController::class, 'storeChapter'])->name('comics.chapters.store');
    Route::delete('/comics/{comicId}/chapters/{chapterId}', [AdminController::class, 'deleteChapter'])->name('comics.chapters.delete');
    
    // Users management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{id}/promote', [AdminController::class, 'promoteUser'])->name('users.promote');
    Route::patch('/users/{id}/demote', [AdminController::class, 'demoteAdmin'])->name('users.demote');
});

// Include auth routes


// Dashboard menggunakan method index yang sama
Route::get('/dashboard', [KomikController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/komik/{komik}/comments', [KomikController::class, 'storeComment'])->name('komik.comments.store');

});

// Route::get('/', [KomikController::class, 'index'])->name('index');
Route::get('/komik/{id}', [KomikController::class, 'show'])->name('komik.show');
Route::get('/search', [KomikController::class, 'search'])->name('komik.search');
Route::post('/upload', [KomikController::class, 'upload'])->name('komik.upload');

// Tambahkan route untuk chapter (perlu dibuat controller method-nya)
// Pastikan route ini ada dan benar
Route::get('/komik/{id}/chapter/{chapter}', [KomikController::class, 'showChapter'])->name('komik.chapter');

Route::get('/genres', [GenreController::class, 'index'])->name('genre.index');
Route::get('/genre/{slug}', [GenreController::class, 'show'])->name('comics.genre');


Route::post('/komik/{komik}/comments', [CommentController::class, 'store'])
    ->name('komik.comments.store')
    ->middleware('auth');

Route::get('/komik/{komik}/comments/load-more', [CommentController::class, 'loadMore'])
    ->name('komik.comments.load-more');

Route::post('/comics/{comic}/comments', [CommentController::class, 'store'])->name('comics.comments.store');

Route::middleware('auth')->group(function () {
    Route::post('/komik/{comic}/comments', [CommentController::class, 'store'])->name('comics.comments.store');
});
require __DIR__.'/auth.php';
