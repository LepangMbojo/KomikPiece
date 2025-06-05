<?php
// app/Models/Chapter.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'komik_id',
        'chapter_number',
        'title',
        'content',
        'pages',
        'views'
    ];  

    protected $casts = [
        'pages' => 'array',
        'views' => 'integer',
        'chapter_number' => 'integer'
    ];

    public function getPagesUrlAttribute()
    {
        if (!$this->pages || !is_array($this->pages)) {
            return [];
        }

        return array_map(function($page) {
            // Jika sudah full URL, return as is
            if (str_starts_with($page, 'http')) {
                return $page;
            }
            
            // Jika path relatif, convert ke storage URL
            if (Storage::disk('public')->exists($page)) {
                return Storage::url($page);
            }
            
            // Coba berbagai kemungkinan path
            $possiblePaths = [
                'chapters/' . $this->komik_id . '/' . $this->chapter_number . '/' . basename($page),
                'chapters/' . $page,
                $page
            ];
            
            foreach ($possiblePaths as $path) {
                if (Storage::disk('public')->exists($path)) {
                    return Storage::url($path);
                }
            }
            
            // Fallback ke placeholder
            return '/placeholder.svg?height=800&width=600&text=Page+' . (array_search($page, $this->pages) + 1);
        }, $this->pages);
    }

    // Relasi dengan komik
    public function komik()
    {
        return $this->belongsTo(Komik::class, 'komik_id');
    }
}