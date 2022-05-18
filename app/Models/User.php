<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class)->withPivot('status');
    }
    
    public function comments()
    {
        return $this -> hasMany(Comment::class);
    }

    // users that are followed by this user
    public function following() {
    return $this->belongsToMany(User::class, 'user_follow', 'follower_id', 'following_id');
    }

    // users that follow this user
    public function followers() {
    return $this->belongsToMany(User::class, 'user_follow', 'following_id', 'follower_id');
    }
}
