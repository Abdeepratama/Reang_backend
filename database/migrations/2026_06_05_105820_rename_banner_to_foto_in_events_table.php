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
        Schema::table('events', function (Blueprint $table) {
            // Mengubah nama kolom banner menjadi foto tanpa mengganggu data lain
            $table->renameColumn('banner', 'foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Antisipasi jika migration di-rollback, kolom kembali jadi banner
            $table->renameColumn('foto', 'banner');
        });
    }
};