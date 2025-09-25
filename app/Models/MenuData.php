<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuData extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit
    protected $table = 'menu_data';

    protected $fillable = [
        'menu_id',
        'judul',
        'isi_konten',
        'gambar_file_path',
    ];

    /**
     * Relasi ke Menu (satu data konten dimiliki oleh satu menu).
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
