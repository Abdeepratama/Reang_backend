<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE dumas MODIFY status ENUM('menunggu', 'diproses', 'selesai', 'ditolak') DEFAULT 'menunggu'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE dumas MODIFY status ENUM('masuk', 'diproses', 'selesai', 'ditolak') DEFAULT 'masuk'");
    }
};
