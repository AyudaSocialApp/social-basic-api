<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiletypeToNeedies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('needies', function (Blueprint $table) {
            $table->char('filetype')->length(30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('needies', function (Blueprint $table) {
            $table->dropTable('filetype');
        });
    }
}
