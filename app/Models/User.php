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
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'is_banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_banned' => 'boolean',
    ];

    public function favorites()
    {
        return $this->belongsToMany(KomikIndex::class, 'komik_user', 'user_id','komik_id' );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'comments_komik', 'content', 'user_id','komik_comment_id');  

    }

    // Method untuk check apakah user adalah admin
    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Method untuk check apakah user adalah user biasa
    public function isUser() : bool
    {
        return $this->role === 'user';
    }
}
