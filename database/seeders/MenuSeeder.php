<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'id' => 3,
                'nama' => 'profil',
                'urutan' => 1,
                'kategori' => 'statis',
                'parent_id' => null,
            ],
            [
                'id' => 2,
                'nama' => 'visi misi',
                'urutan' => 1,
                'kategori' => 'statis',
                'parent_id' => 3,
            ],
            [
                'id' => 4,
                'nama' => 'kontak',
                'urutan' => 3,
                'kategori' => 'statis',
                'parent_id' => null,
            ],
            [
                'id' => 5,
                'nama' => 'sejarah',
                'urutan' => 2,
                'kategori' => 'statis',
                'parent_id' => 3,
            ],
            [
                'id' => 6,
                'nama' => 'struktur',
                'urutan' => 3,
                'kategori' => 'statis',
                'parent_id' => 3,
            ],
            [
                'id' => 7,
                'nama' => 'publikasi',
                'urutan' => 2,
                'kategori' => 'statis',
                'parent_id' => null,
            ],
            [
                'id' => 8,
                'nama' => 'galeri',
                'urutan' => 0,
                'kategori' => 'dinamis',
                'parent_id' => 7,
            ],
            [
                'id' => 9,
                'nama' => 'berita',
                'urutan' => 1,
                'kategori' => 'dinamis',
                'parent_id' => 7,
            ],
            [
                'id' => 10,
                'nama' => 'dokumen',
                'urutan' => 4,
                'kategori' => 'dinamis-tabel',
                'parent_id' => null,
            ],
        ]);
    }
}
