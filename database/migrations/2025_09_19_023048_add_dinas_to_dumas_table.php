<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dumas', function (Blueprint $table) {
            $table->string('dinas')->nullable()->after('kategori_laporan');
        });
    }

    public function down(): void
    {
        Schema::table('dumas', function (Blueprint $table) {
            $table->dropColumn('dinas');
        });
    }
};
