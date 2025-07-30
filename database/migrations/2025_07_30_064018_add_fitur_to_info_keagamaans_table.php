<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('info_keagamaans', function (Blueprint $table) {
            $table->string('fitur')->nullable();
        });
    }

    public function down()
    {
        Schema::table('info_keagamaans', function (Blueprint $table) {
            $table->dropColumn('fitur');
        });
    }
};
