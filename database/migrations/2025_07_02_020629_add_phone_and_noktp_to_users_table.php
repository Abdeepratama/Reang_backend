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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email'); // Contoh: setelah email
            $table->string('no_ktp')->nullable()->unique()->after('phone'); // Contoh: setelah phone, unik
            // Anda bisa menyesuaikan posisi dan properti (nullable, unique, dll.)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'no_ktp']);
        });
    }
};