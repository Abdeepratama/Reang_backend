<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dumas_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dumas_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('rating'); // 1-5
            $table->timestamps();

            $table->foreign('dumas_id')->references('id')->on('dumas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['dumas_id', 'user_id']); // user hanya bisa kasih 1 rating per dumas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dumas_ratings');
    }
};
