<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuData extends Model
{
    use HasFactory;

    protected $table = 'menu_data';

    protected $fillable = [
        'menu_id',
        'judul',
        'isi_konten',
        'gambar_file_path',
        'file_path', // <-- TAMBAHKAN BARIS INI
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
