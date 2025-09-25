<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['nama', 'cover_album_url'];

    public function galeri()
    {
        return $this->hasMany(Galeri::class, 'album_id');
    }
}
