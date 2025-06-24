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

            if (str_starts_with($page, 'http')) {
                return $page;
            }
            
            if (Storage::disk('public')->exists($page)) {
                return Storage::url($page);
            }
            
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
            return '/placeholder.svg?height=800&width=600&text=Page+' . (array_search($page, $this->pages) + 1);
        }, $this->pages);
    }

    public function komik()
    {
        return $this->belongsTo(Komik::class, 'komik_id');
    }
}