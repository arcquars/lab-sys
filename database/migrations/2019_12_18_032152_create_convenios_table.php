<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('bancaMatricula', 250);
            $table->string('bancaPreAfiliacion', 250)->nullable();
            $table->string('bancaActivoAsegurado', 250)->nullable();
            $table->string('bancaActivoExt', 250)->nullable();
            $table->string('bancaActivoResto', 250)->nullable();
            $table->string('bancaPasivoAsegurado', 250)->nullable();
            $table->string('bancaPasivoExt', 250)->nullable();
            $table->string('bancaPasivoResto', 250)->nullable();
            $table->string('bancaSecAsegurado', 250)->nullable();
            $table->string('bancaSecExt', 250)->nullable();
            $table->string('bancaSecResto', 250)->nullable();
            $table->string('bancaEspecialidad', 250)->nullable();
            $table->string('bancaAmbulatorio', 250)->nullable();
            $table->string('bancaHospitalizado', 250)->nullable();

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('convenios', function (Blueprint $table) {
            $table->bigInteger('analisis_id')->unsigned();
            $table->foreign('analisis_id')->references('id')->on('analisis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convenios');
    }
}
