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
        // 1. Tabel Master: Menyimpan Informasi Utama Event
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event');
            $table->text('deskripsi');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai'); // Kolom acuan logic otomatisasi waktu
            $table->string('foto')->nullable(); // GANTI: Banner diubah menjadi foto
            $table->timestamps();
        });

        // 2. Tabel Anak: Menyimpan Banyak Kelas Tiket per Event (One-to-Many)
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            // Tali pengikat ke tabel master events
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('nama_kelas'); // Contoh: VIP, Reguler, Early Bird
            $table->integer('harga');
            $table->integer('kuota');
            $table->integer('terjual')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_tickets');
        Schema::dropIfExists('events');
    }
};