<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTypeNeedyIdToHelps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helps', function (Blueprint $table) {
            $table->dropForeign('helps_type_needy_id_foreign');
            $table->dropColumn('type_needy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('helps', function (Blueprint $table) {
            $table->integer('type_needy_id')->length(10)->unsigned();
            $table->foreign('type_needy_id')->references('id')->on('typeneedies');
        });
    }
}
