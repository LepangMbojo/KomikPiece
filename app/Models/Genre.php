<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\GenreFactory;
use App\Models\KomikIndex;
use Illuminate\Support\Str;


class Genre extends Model
{

    use HasFactory;

    protected $table = 'genres';
    
    protected $fillable = ['name', 'slug', 'description'];

    public function komiks()
    {
        return $this->belongsToMany(KomikIndex::class, 'genre_komik', 'genre_id', 'komik_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($genre) {
            if (empty($genre->slug)) {
                $genre->slug = Str::slug($genre->name);
            }
        });
    }


}
