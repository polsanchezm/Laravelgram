<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // definim la taula d'imatges
    protected $table = "images";

    // definim les variables que es poden emplenar
    protected $fillable = [
        'image_path',
        'description',
        'user_id'
    ];

    // creem les relacions entre les taules
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('id', 'desc');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

