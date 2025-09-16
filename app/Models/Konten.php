<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $fillable = [
        'judul',
        'file_path',
        'tgl_upload',
        'konten',
    ];
}
