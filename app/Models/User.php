<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\KomikIndex;



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
];

    public function favoriteKomiks()
    {
        return $this->belongsToMany(KomikIndex::class, 'komik_user', 'komik_fav_id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'comments_komik', 'content', 'user_id','komik_comment_id');  

    }

    // Method untuk check apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Method untuk check apakah user adalah user biasa
    public function isUser()
    {
        return $this->role === 'user';
    }
}
