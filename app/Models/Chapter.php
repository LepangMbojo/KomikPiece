<?php
// app/Models/Chapter.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'komik_id',
        'chapter_number',
        'title',
        'content',
        'images',
        'views'
    ];  

    protected $casts = [
        'pages' => 'array',
        'views' => 'integer',
        'chapter_number' => 'integer'
    ];

    // Relasi dengan komik
    public function komik()
    {
        return $this->belongsTo(Komik::class, 'komik_id');
    }
}