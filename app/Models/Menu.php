<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Properti yang boleh diisi secara massal
    protected $fillable = [
        'nama',
        'urutan',
        'kategori',
        'parent_id',
    ];

    // Relasi ke parent (satu menu memiliki satu parent)
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // Relasi ke children (satu menu bisa memiliki banyak anak)
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('urutan');
    }
}
