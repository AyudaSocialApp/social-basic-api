<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatecontributorsTable extends Migration
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
        Schema::create('contributors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('names');
            $table->string('last_names');
            $table->boolean('privacy');
            $table->integer('type_identifications_id')->length(10)->unsigned();
            $table->char('nit_id')->length(40);
            $table->integer('type_contributors_id')->length(10)->unsigned();
            $table->char('filetype')->length(40);
            $table->string('cellphone_telephone_contact');
            $table->integer('users_id')->length(10)->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('type_identifications_id')->references('id')->on('typeidentifications');
            $table->foreign('type_contributors_id')->references('id')->on('typecontributors');
        });

        \DB::statement("ALTER TABLE contributors ADD base64 LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contributors');
    }
}
