<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoPagoAcuentaToAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->string('tipo_pago_acuenta')->default("EFECTIVO");
            $table->string('tipo_pago_efectuado')->default("EFECTIVO");
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
            $table->dropColumn('tipo_pago_acuenta');
            $table->dropColumn('tipo_pago_efectuado');
        });
    }
}
