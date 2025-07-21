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
            $table->string('kategori'); // contoh: Wisata Alam, Budaya, dll
            $table->text('deskripsi');
            $table->float('rating')->default(0);
            $table->integer('harga')->default(0);
            $table->string('lokasi_text'); // contoh: "Balongan, Jawa Barat"
            $table->decimal('latitude', 10, 7)->nullable(); // contoh: -6.6512345
            $table->decimal('longitude', 10, 7)->nullable(); // contoh: 108.4532100
            $table->string('admin_nama');
            $table->string('gambar')->nullable(); // path file gambar
            $table->timestamps();
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
