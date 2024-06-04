<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupervisarToAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('analisis', function (Blueprint $table) {
            $table->boolean('supervisar')->default(false);
            $table->bigInteger('doctor_supervisor')->nullable(true);
            $table->text('comentario_supervisor')->nullable(true);
            $table->bigInteger('user_asig_supervisor')->nullable(true);
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
            $table->dropColumn('supervisar');
            $table->dropColumn('doctor_supervisor');
            $table->dropColumn('comentario_supervisor');
            $table->dropColumn('user_asig_supervisor');
        });
    }
}
