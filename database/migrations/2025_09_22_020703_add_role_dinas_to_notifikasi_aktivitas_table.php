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
        Schema::table('notifikasi_aktivitas', function (Blueprint $table) {
            $table->string('role')->nullable()->after('url');   // target role
            $table->string('dinas')->nullable()->after('role'); // target dinas (opsional)
        });
    }

    public function down()
    {
        Schema::table('notifikasi_aktivitas', function (Blueprint $table) {
            $table->dropColumn(['role', 'dinas']);
        });
    }
};
