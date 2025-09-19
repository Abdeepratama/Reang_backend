<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentToDumasRatingsTable extends Migration
{
    public function up()
    {
        Schema::table('dumas_ratings', function (Blueprint $table) {
            $table->text('comment')->nullable()->after('rating');
        });
    }

    public function down()
    {
        Schema::table('dumas_ratings', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
    }
}