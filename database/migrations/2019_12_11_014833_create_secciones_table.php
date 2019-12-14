<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('seccion');
            $table->string('key');
            $table->string('value');

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('secciones', function (Blueprint $table) {
            $table->bigInteger('resultado_id')->unsigned();
            $table->foreign('resultado_id')->references('id')->on('resultados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secciones');
    }
}
