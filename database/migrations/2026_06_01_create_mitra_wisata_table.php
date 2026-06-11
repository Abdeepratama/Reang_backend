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
        Schema::create('mitra_wisata', function (Blueprint $table) {
            $table->id(); // Primary Key otomatis
            
            // Relasi ke tabel users (Hapus comment ini jika user wajib login dulu sebelum daftar)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom utama berdasarkan file gambar layout awal kamu
            $table->string('nama_wisata', 255)->comment('Nama Objek Wisata');
            $table->text('alamat')->comment('Alamat Lengkap');
            $table->string('no_whatsapp', 20)->comment('Nomor WhatsApp / Kontak');
            $table->text('deskripsi')->comment('Deskripsi Singkat');
            
            // Kolom tambahan rekomendasi untuk kebutuhan fungsionalitas TA
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('Status Verifikasi');
            $table->string('foto_wisata', 255)->nullable()->comment('Path atau file foto tempat wisata');
            $table->decimal('latitude', 10, 8)->nullable()->comment('Koordinat peta (Latitude)');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Koordinat peta (Longitude)');
            
            $table->timestamps(); // created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_wisata');
    }
};