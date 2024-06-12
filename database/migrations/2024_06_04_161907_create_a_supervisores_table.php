<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateASupervisoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_supervisores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('estado')->default('SIN VERIFICAR');
            $table->text('comentario')->nullable(true);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('a_supervisores', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('analisis_id')->unsigned();
            $table->foreign('analisis_id')->references('id')->on('analisis');

            $table->bigInteger('doctor_id')->unsigned();
            $table->foreign('doctor_id')->references('id')->on('doctores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_supervisores');
    }
}
