<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // definim la taula d'usuaris
    protected $table = 'users';

    // definim les variables que es poden emplenar
    protected $fillable = [
        'role',
        'avatar',
        'name',
        'surname',
        'nick',
        'email',
        'password',
    ];

    // definim les variables que es han de ser ocultes
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // definim les variables que han de ser convertits a altres tipus de dades 
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // creem les relacions entre les taules
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'user_id');
    }
}
