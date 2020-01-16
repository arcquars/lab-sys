<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDoctorAsignadoForAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->bigInteger('doctor_asignado')->default(1);
            //$table->foreign('doctor_asignado')->references('id')->on('doctores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->dropColumn('doctor_asignado');
        });
    }
}
