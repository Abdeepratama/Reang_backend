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
        Schema::table('tempat_ibadah', function (Blueprint $table) {
            $table->string('foto')->nullable(); // menyimpan path foto
        });
    }

    public function down()
    {
        Schema::table('tempat_ibadah', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
