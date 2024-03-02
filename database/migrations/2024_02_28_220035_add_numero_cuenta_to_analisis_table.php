<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumeroCuentaToAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->string('acuenta_numero_tarjeta')->default(null);
            $table->string('acuenta_banco')->default(null);

            $table->string('saldo_numero_tarjeta')->default(null);
            $table->string('saldo_banco')->default(null);
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
            $table->dropColumn('acuenta_numero_tarjeta');
            $table->dropColumn('acuenta_banco');
            $table->dropColumn('saldo_numero_tarjeta');
            $table->dropColumn('saldo_banco');
        });
    }
}
