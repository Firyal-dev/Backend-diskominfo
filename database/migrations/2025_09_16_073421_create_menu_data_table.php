<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_menu_data_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_data', function (Blueprint $table) {
            $table->id();

            // Kunci asing yang terhubung ke tabel 'menus'
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');

            $table->string('judul');
            $table->longText('isi_konten'); // Menggunakan longText untuk isi yang panjang (misal: artikel)
            $table->string('gambar_file_path')->nullable(); // Path untuk gambar atau file

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_data');
    }
};
