<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\KomikIndex;

class Comments extends Model
{
    use HasFactory; // ✅ Tambahkan ini agar bisa gunakan factory

   protected $fillable = [
        'user_id',
        'komik_id', 
        'content'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function komik()
    {
        return $this->belongsTo(Komik::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
