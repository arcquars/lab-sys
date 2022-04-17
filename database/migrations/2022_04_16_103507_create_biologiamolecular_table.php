<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiologiamolecularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biologia_molecular', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('interpretacion')->nullable(true);
            $table->text('tecnica')->nullable(true);
            $table->text('bibliografia')->nullable(true);

            $table->string('imagen1')->nullable();
            $table->string('imagen2')->nullable();
            $table->string('imagen3')->nullable();

            $table->string('imagen4')->nullable();
            $table->string('titulo_1')->nullable();
            $table->string('titulo_2')->nullable();
            $table->string('titulo_3')->nullable();
            $table->string('titulo_4')->nullable();

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('biologia_molecular', function (Blueprint $table) {
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
        Schema::dropIfExists('biologia_molecular');
    }
}
