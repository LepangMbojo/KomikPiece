<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomikIndex;
use App\Models\Genre;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{
   use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($genre) {
            if (empty($genre->slug)) {
                $genre->slug = Str::slug($genre->name);
            }
        });
    }

    /**
     * Get the komiks for the genre.
     */
    public function komiks()
    {
        // Sesuaikan dengan nama model dan foreign key Anda
        return $this->belongsToMany(
            Komik::class,           // Atau KomikIndex::class
            'komik_genre',          
            'genre_id',             
            'komik_id'              // Atau 'komik_index_id'
        );
    }
}
