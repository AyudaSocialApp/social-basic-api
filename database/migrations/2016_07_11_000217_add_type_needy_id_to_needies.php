<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeneedyidToNeedies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('needies', function (Blueprint $table) {
        $table->integer('type_needy_id')->length(10)->unsigned()->default(2);
        $table->index(['type_needy_id']);
        $table->foreign('type_needy_id')->references('id')->on('typeneedies');
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
          $table->dropForeign('type_needy_id');
          $table->dropIndex('type_needy_id');
          $table->dropColumn('type_needy_id');
      });
    }
}
