<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\KomikIndexFactory;
use App\Models\User;
use App\Models\Comment;
use App\Models\Genre;


class KomikIndex extends Model
{
    use HasFactory;

protected $table = 'komiks';
// app/Models/Komik.php

protected $fillable = [
    'judul',
    'slug', 
        'description',
        'author',
        'cover_image',
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
        return $this->belongsToMany(User::class, 'komik_user', 'komik_fav_id', 'user_id');
    }

   public function comments()
    {
        return $this->hasMany(Comment::class, 'komik_id');
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
