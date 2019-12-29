<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiopsiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biopsias', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('organo_tejido')->nullable(true);
            $table->text('macroscopia')->nullable(true);
            $table->text('microscopia')->nullable(true);
            $table->text('diagnostico')->nullable(true);

            $table->bigInteger('user_organo_tejido')->nullable();
            $table->bigInteger('user_macroscopia')->nullable();
            $table->bigInteger('user_microscopia')->nullable();
            $table->bigInteger('user_diagnostico')->nullable();

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('biopsias', function (Blueprint $table) {
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
        Schema::dropIfExists('biopsias');
    }
}
