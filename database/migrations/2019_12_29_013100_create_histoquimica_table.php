<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoquimicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histoquimicas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('interpretacion')->nullable(true);
            $table->text('tecnica')->nullable(true);
            $table->text('bibliografia')->nullable(true);

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('histoquimicas', function (Blueprint $table) {
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
        Schema::dropIfExists('histoquimicas');
    }
}
