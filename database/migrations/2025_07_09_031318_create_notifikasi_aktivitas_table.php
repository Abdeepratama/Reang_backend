<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiAktivitasTable extends Migration
{
    public function up()
    {
        Schema::create('notifikasi_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->text('keterangan');
            $table->boolean('dibaca')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasi_aktivitas');
    }
}
