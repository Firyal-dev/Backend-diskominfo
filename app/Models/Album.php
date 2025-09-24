<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['nama', 'deskripsi'];

    public function galeri()
    {
        return $this->hasMany(Galeri::class);
    }
}
