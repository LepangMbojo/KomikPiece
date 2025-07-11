<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\KomikIndexFactory;
use App\Models\User;
use App\Models\Comments;
use App\Models\Genre;

use Illuminate\Support\Facades\Storage;

class KomikIndex extends Model
{
    use HasFactory;

protected $table = 'komiks';
// app/Models/Komik.php

protected $fillable = [
        'judul',
        'language',
        'cover',
        'author',
        'description',
        'status',
        'rating',
        'views'
        
    ];

    protected $casts = [
        'rating' => 'integer',
        'chapter' => 'integer',
        'Favorite' => 'integer',
        'views' => 'integer'
    ];

    public function getCoverImageAttribute()
    {
        
        if ($this->cover) {
            return Storage::url($this->cover);
        }
        
        $possibleCovers = [
            'covers/' . $this->id . '.jpg',
            'covers/' . $this->id . '.png',
            'covers/' . $this->id . '.jpeg',
            'covers/' . str_replace(' ', '_', strtolower($this->judul)) . '.jpg',
            'covers/' . str_replace(' ', '_', strtolower($this->judul)) . '.png',
        ];
        foreach ($possibleCovers as $coverPath) {
            if (Storage::disk('public')->exists($coverPath)) {
                return Storage::url($coverPath);
            }
        }
        
        return '/placeholder.svg?height=350&width=250&text=' . urlencode($this->judul);
    }

    
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'komik_id');
    }

    protected static function newFactory()
    {
        return KomikIndexFactory::new();
    }
    public function favoredByUsers()
    {
        return $this->belongsToMany(User::class, 'komik_user', 'komik_id', 'user_id');
    }

public function comments()
{
    return $this->hasMany(Comments::class, 'komik_id')->latest();
}
    public function genres()
    {
        return $this->belongsToMany(
            Genre::class,           
            'genre_komik',          // Nama tabel pivot
            'komik_id',             // Foreign key untuk model ini
            'genre_id'              // Foreign key untuk model Genre
        );
    }
    
    public function getLatestChapterAttribute()
    {
        
        if ($this->relationLoaded('chapters')) {
            
            return $this->chapters->max('chapter_number') ?? 0;
        }
        return $this->chapters()->max('chapter_number') ?? 0;
    }

}
