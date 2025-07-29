<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tempat_ibadah', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['kategori_id']);

            // Baru hapus kolomnya
            $table->dropColumn('kategori_id');
        });
    }

    public function down(): void
    {
        Schema::table('tempat_ibadah', function (Blueprint $table) {
            // Tambahkan kembali kolom dan foreign key-nya
            $table->unsignedBigInteger('kategori_id')->nullable();

            $table->foreign('kategori_id')
                ->references('id')->on('kategoris')
                ->onDelete('set null');
        });
    }
};
