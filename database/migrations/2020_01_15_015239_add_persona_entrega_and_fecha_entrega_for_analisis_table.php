<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPersonaEntregaAndFechaEntregaForAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->string('persona_entrega', 180)->nullable();
            $table->date('fecha_cierre')->nullable();
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
            $table->dropColumn('persona_entrega');
            $table->dropColumn('fecha_cierre');
        });
    }
}
