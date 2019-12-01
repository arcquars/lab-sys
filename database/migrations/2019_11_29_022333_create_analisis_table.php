<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('doctor', 255);

            $table->string('tipo_analisis', 255);
            $table->date('fecha');
            $table->string('region', 255);
            $table->decimal('precio', 10, 2);
            $table->decimal('acuenta', 10, 2)->default(0);
            $table->text('observaciones')->nullable();

            $table->boolean('delete')->default(false);
            $table->timestamps();
        });

        Schema::table('analisis', function (Blueprint $table) {
            $table->bigInteger('procedencia')->unsigned();
            $table->foreign('procedencia')->references('id')->on('instituciones');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analisis');
    }
}
