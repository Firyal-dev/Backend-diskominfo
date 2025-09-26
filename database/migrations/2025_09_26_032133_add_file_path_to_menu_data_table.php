<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_data', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom gambar
            $table->string('file_path')->nullable()->after('gambar_file_path');
        });
    }

    public function down(): void
    {
        Schema::table('menu_data', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
