<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\KomikIndex;
use App\Models\Comment;



class User extends Authenticatable
{
  
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_banned'
    ];

   
    protected $hidden = [
        'password',
        'remember_token',
    ];

  
    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_banned' => 'boolean',
    ];

    public function favorites()
    {
        return $this->belongsToMany(KomikIndex::class, 'komik_user', 'user_id','komik_id' )  ->withTimestamps(); 
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'comments_komik', 'content', 'user_id','komik_comment_id');  

    }
    
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser() : bool
    {
        return $this->role === 'user';
    }
}
