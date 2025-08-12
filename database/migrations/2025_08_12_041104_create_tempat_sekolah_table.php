<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('tempat_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama sekolah
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('address')->nullable();
            $table->text('fitur')->nullable(); // Deskripsi fasilitas
            $table->string('foto')->nullable(); // Path foto
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_sekolahs');
    }
};
