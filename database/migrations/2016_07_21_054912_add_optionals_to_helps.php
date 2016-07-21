<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionalsToHelps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helps', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->text('place_delivery')->nullable()->change();
            $table->datetime('date_hour')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('helps', function (Blueprint $table) {
            $table->text('description')->change();
            $table->date('date')->change();
            $table->text('place_delivery')->change();
            $table->datetime('date_hour')->change();
        });
    }
}
