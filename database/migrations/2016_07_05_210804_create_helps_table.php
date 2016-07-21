<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatehelpsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*
            1. Cambiar los binary a longblob
            2. Ajustar la longitud de los char
            3. Agregar "No firma" y tamaño a futuras foraneas
            4. Agregar los indices y foraneas
        */

        Schema::create('helps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_helps_id')->length(10)->unsigned();
            $table->text('description');
            $table->date('date');
            $table->integer('contributors_id')->nullable()->length(10)->unsigned();
            $table->integer('needy_id')->length(10)->unsigned();
            $table->text('place_delivery');
            $table->dateTime('date_hour');
            $table->boolean('delivered');
            $table->integer('type_needy_id')->length(10)->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('type_helps_id')->references('id')->on('typehelps');
            $table->foreign('contributors_id')->references('id')->on('contributors');
            $table->foreign('needy_id')->references('id')->on('needies');
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
        Schema::drop('helps');
    }
}
