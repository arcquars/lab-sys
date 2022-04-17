<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcadorsbiologiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcador_biologias', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nombre')->nullable(true);
            $table->string('resultado')->nullable(true);

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('marcador_biologias', function (Blueprint $table) {
            $table->bigInteger('biologiam_id')->unsigned();
            $table->foreign('biologiam_id')->references('id')->on('biologia_molecular');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcador_biologias');
    }
}
