<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_xxxxxx_create_menus_table.php
public function up(): void
{
    Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->integer('urutan')->default(0);
        $table->enum('kategori', ['statis', 'dinamis', 'dinamis-tabel']);

        // <-- PASTIKAN BARIS INI ADA
        $table->foreignId('parent_id')->nullable()->constrained('menus')->onDelete('cascade');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
