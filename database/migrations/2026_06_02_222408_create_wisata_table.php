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
        Schema::create('wisata', function (Blueprint $table) {
            $table->id();
            $table->string('nama_wisata');
            $table->string('kategori_wisata');
            $table->text('deskripsi');
            $table->text('alamat');
            $table->string('jam_operasional');
            $table->integer('harga_tiket');
            $table->integer('kuota_per_hari');
            $table->json('fasilitas'); // Menyimpan array fasilitas (Toilet, Masjid, dll)
            $table->string('foto')->nullable(); // Menyimpan path gambar utama
            $table->timestamps(); // Menghasilkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata');
    }
};