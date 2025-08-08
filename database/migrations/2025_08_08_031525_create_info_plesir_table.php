<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('info_plesir', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('alamat');
            $table->decimal('rating', 3, 2)->nullable(); // contoh: 4.75
            $table->text('deskripsi');
            $table->string('foto')->nullable(); // untuk path file foto
            $table->string('fitur'); // kategori seperti: taman, wisata, dll
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('info_plesir');
    }
};
