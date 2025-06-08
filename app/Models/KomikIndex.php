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
        'cover',
        'genre',
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
        // Jika ada cover di database, gunakan itu
        if ($this->cover) {
            return Storage::url($this->cover);
        }
        
        // Jika tidak ada, coba cari file berdasarkan nama komik
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
        
        // Fallback ke placeholder
        return '/placeholder.svg?height=350&width=250&text=' . urlencode($this->judul);
    }

    // Cek apakah cover exists
    public function getCoverExistsAttribute()
    {
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return true;
        }
        
        $possibleCovers = [
            'covers/' . $this->id . '.jpg',
            'covers/' . $this->id . '.png',
            'covers/' . $this->id . '.jpeg',
        ];
        
        foreach ($possibleCovers as $coverPath) {
            if (Storage::disk('public')->exists($coverPath)) {
                return true;
            }
        }
        
        return false;
    }

    // Relasi dengan chapters
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
    return $this->hasMany(\App\Models\Comments::class, 'komik_id')->latest();
}
     public function genres()
    {
        return $this->belongsToMany(
            Genre::class,           // Model yang dihubungkan
            'komik_genre',          // Nama tabel pivot
            'komik_id',             // Foreign key untuk model ini
            'genre_id'              // Foreign key untuk model Genre
        );
    }
    
    public function getLatestChapterAttribute()
    {
        return $this->chapters()->max('chapter_number') ?? 0;
    }

}
