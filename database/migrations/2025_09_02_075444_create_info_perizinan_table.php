<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_perizinan', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('judul');
            $table->longText('deskripsi'); 
            $table->string('fitur'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_perizinan');
    }
};
