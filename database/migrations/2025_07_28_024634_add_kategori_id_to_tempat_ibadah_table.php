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
            $table->unsignedBigInteger('kategori_id')->nullable()->after('address');

            // Jika ada relasi foreign key:
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tempat_ibadah', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
