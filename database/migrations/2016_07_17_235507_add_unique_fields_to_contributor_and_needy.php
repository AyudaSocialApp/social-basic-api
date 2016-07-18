<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueFieldsToContributorAndNeedy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('contributors', function (Blueprint $table) {
            $table->unique('users_id');
        });

        Schema::table('needies', function (Blueprint $table) {
            $table->unique('users_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributors', function (Blueprint $table) {
            $table->dropIndex('users_id');
        });
        Schema::table('needies', function (Blueprint $table) {
            $table->dropIndex('users_id');
        });
    }
}
