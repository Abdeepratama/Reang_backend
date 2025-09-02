<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('info_kerja', function (Blueprint $table) {
            $table->string('gaji')->change();
        });
    }

    public function down(): void
    {
        Schema::table('info_kerja', function (Blueprint $table) {
            $table->decimal('gaji', 15, 2)->change(); // balikin ke decimal
        });
    }
};

