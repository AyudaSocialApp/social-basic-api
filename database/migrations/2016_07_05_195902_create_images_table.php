<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateimagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->char('filetype')->length(30);
            $table->integer('needy_id')->length(10)->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['needy_id']);
            $table->foreign('needy_id')->references('id')->on('needies');
        });

        \DB::statement("ALTER TABLE images ADD base64 LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
