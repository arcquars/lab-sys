<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcadors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nombre')->nullable(true);
            $table->string('resultado')->nullable(true);

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('marcadors', function (Blueprint $table) {
            $table->bigInteger('histoquimica_id')->unsigned();
            $table->foreign('histoquimica_id')->references('id')->on('histoquimicas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcadors');
    }
}
