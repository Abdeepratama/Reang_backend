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
        Schema::create('info_keagamaans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('tanggal');
            $table->time('waktu');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->string('alamat');
            $table->string('kategori');
            $table->string('foto')->nullable(); // disimpan sebagai path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_keagamaans');
    }
};
