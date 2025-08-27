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
        Schema::create('info_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('judul');
            $table->longText('deskripsi'); // panjang untuk artikel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_sekolah');
    }
};
