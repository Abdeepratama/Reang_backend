<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('sekolahs', function (Blueprint $table) {
        $table->id();
        $table->string('jenis_laporan');
        $table->string('kategori_laporan');
        $table->text('lokasi_laporan')->nullable();
        $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
        $table->string('bukti_laporan')->nullable();
        $table->text('deskripsi');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolahs');
    }
};
