<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPersonDefaultPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('persons')->insert(
            array(
                [
                    'ci' => '6000000',
                    'nombres' => 'Sin nombre',
                    'apellidos' => 'Sin apellido',
                    'f_nacimiento' => '2022-12-12',
                    'sexo' => 'mujer',
                    'edad' => '0'
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            //
        });
    }
}
