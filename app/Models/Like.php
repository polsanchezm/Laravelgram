<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // definim la taula de likes
    protected $table = 'likes';

    // definim les variables que es poden emplenar
    protected $fillable = [
        'user_id',
        'image_id',
    ];


    // creem les relacions entre les taules
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
