<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('info_pajak', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable(); // path foto
            $table->string('judul');           // judul info pajak
            $table->longText('deskripsi');         // deskripsi konten (pakai text biar bisa panjang/HTML)
            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_pajak');
    }
};
