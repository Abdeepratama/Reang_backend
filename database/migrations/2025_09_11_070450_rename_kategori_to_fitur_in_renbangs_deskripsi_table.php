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
        Schema::table('renbangs_deskripsi', function (Blueprint $table) {
            $table->renameColumn('kategori', 'fitur');
        });
    }

    public function down(): void
    {
        Schema::table('renbangs_deskripsi', function (Blueprint $table) {
            $table->renameColumn('fitur', 'kategori');
        });
    }
};
