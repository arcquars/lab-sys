<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBethestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bethesda', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('celulas_observadas')->nullable(true);
            $table->text('calidad_muestra')->nullable(true);
            $table->text('clasificacion_general')->nullable(true);
            $table->text('interpretacion')->nullable(true);
            $table->text('observaciones')->nullable(true);


            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('bethesda', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('bethesda');
    }
}
