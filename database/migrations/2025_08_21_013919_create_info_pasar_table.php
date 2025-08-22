<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('info_pasar', function (Blueprint $table) {
            $table->id();
            $table->string('nama');               // nama pasar
            $table->string('alamat');             // alamat pasar
            $table->string('foto')->nullable();   // foto pasar
            $table->string('fitur');              // fitur kategori (misal: pasar tradisional, modern, dll)
            $table->decimal('latitude', 10, 7);   // latitude lokasi
            $table->decimal('longitude', 10, 7);  // longitude lokasi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_pasar');
    }
};
