<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'file_path',
        'tgl_upload',
        'album_id',
    ];

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
