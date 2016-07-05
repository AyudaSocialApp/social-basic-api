<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('ideas', function (Blueprint $table) {
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
      Schema::table('ideas', function (Blueprint $table) {
        $table->dropForeign(['users_id']);
        $table->dropIndex(['users_id']); 
      });
    }
  }
