<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('judul'); 
            $table->text('alamat');
            $table->decimal('gaji', 15, 2)->nullable();
            $table->string('nomor_telepon', 20)->nullable(); 
            $table->string('waktu_kerja')->nullable();
            $table->string('jenis_kerja')->nullable();
            $table->string('fitur'); //kategori
            $table->string('foto')->nullable();
            $table->longText('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_kerja');
    }
};
