<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelefonoReferenciaForAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->string('telefono_referencia', 14)->nullable();
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
            $table->dropColumn('telefono_referencia');
        });
    }
}
