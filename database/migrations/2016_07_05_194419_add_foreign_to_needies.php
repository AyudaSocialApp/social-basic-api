<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToNeedies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('needies', function (Blueprint $table) {
            $table->integer('type_identifications_id')->length(10)->unsigned()->change();
            $table->index(['type_identifications_id']);
            $table->foreign('type_identifications_id')->references('id')->on('typeidentifications');

            $table->integer('users_id')->length(10)->unsigned()->change();
            $table->index(['users_id']);
            $table->foreign('users_id')->references('id')->on('users');
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
            $table->dropForeign(['type_identifications_id']);
            $table->dropIndex(['type_identifications_id']); 
            $table->dropForeign(['users_id']);
            $table->dropIndex(['users_id']); 
        });
    }
}
