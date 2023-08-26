<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected function avatar(): Attribute {
        return Attribute::make(get: function($value){
            return $value ? '/storage/avatars/'.$value: '/fallback-avatar.jpg';
        });
    }

    

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
        'password' => 'hashed',
    ];

    public function posts() {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function followers() {
        return $this->hasMany(Follow::class, 'followedUser', 'id');
    }

    public function followingTheseUsers() {
        return $this->hasMany(Follow::class, 'user_id', 'id');
    }

    public function feedPosts(){
        return $this->hasManyThrough(Review::class, Follow::class,'user_id','user_id','id','followedUser'); //The table has to bypass a sort of checkpoint (1."Final model", 2."Intermediate Table", 3."Foregin key on intermediate table", 4."Foreign key on Final Model", 5."local key", 6."Local key on intermediate table" )
    }

    public function toSearchableArray(){ //Fixed or, Pre-defined function
        return [
            'username' => $this-> username,
            'email'=> $this-> email 
        ];
    }
}