<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsHistopatologicoForBiopsiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biopsias', function (Blueprint $table) {
            $table->boolean('is_histopatologico')->default(false);
            $table->string('histopatologico_imagenes1')->nullable();
            $table->string('histopatologico_nombre1')->nullable();
            $table->string('histopatologico_imagenes2')->nullable();
            $table->string('histopatologico_nombre2')->nullable();
            $table->string('histopatologico_imagenes3')->nullable();
            $table->string('histopatologico_nombre3')->nullable();
            $table->string('histopatologico_imagenes4')->nullable();
            $table->string('histopatologico_nombre4')->nullable();
            $table->string('histopatologico_imagenes5')->nullable();
            $table->string('histopatologico_nombre5')->nullable();
            $table->string('histopatologico_imagenes6')->nullable();
            $table->string('histopatologico_nombre6')->nullable();
            $table->string('histopatologico_imagenes7')->nullable();
            $table->string('histopatologico_nombre7')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biopsias', function (Blueprint $table) {
            $table->dropColumn('is_histopatologico');
            $table->dropColumn('histopatologico_imagenes1');
            $table->dropColumn('histopatologico_nombre1');
            $table->dropColumn('histopatologico_imagenes2');
            $table->dropColumn('histopatologico_nombre2');
            $table->dropColumn('histopatologico_imagenes3');
            $table->dropColumn('histopatologico_nombre3');
            $table->dropColumn('histopatologico_imagenes4');
            $table->dropColumn('histopatologico_nombre4');
            $table->dropColumn('histopatologico_imagenes5');
            $table->dropColumn('histopatologico_nombre5');
            $table->dropColumn('histopatologico_imagenes6');
            $table->dropColumn('histopatologico_nombre6');
            $table->dropColumn('histopatologico_imagenes7');
            $table->dropColumn('histopatologico_nombre7');

        });
    }
}
