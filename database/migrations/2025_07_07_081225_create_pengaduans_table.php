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
        Schema::create('pengaduans', function (Blueprint $table) {
    $table->id();
    $table->string('jenis_laporan');
    $table->string('kategori_laporan');
    $table->string('lokasi_laporan')->nullable();
    $table->text('deskripsi');
    $table->string('bukti_laporan')->nullable(); // untuk path foto
    $table->text('pernyataan')->nullable();
    $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('masuk');
    $table->text('tanggapan')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
