<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImage4AndTitulos1234ForHistoquimicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histoquimicas', function (Blueprint $table) {
            $table->string('imagen4')->nullable();
            $table->string('titulo_1')->nullable();
            $table->string('titulo_2')->nullable();
            $table->string('titulo_3')->nullable();
            $table->string('titulo_4')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('histoquimicas', function (Blueprint $table) {
            $table->dropColumn('imagen4');
            $table->dropColumn('titulo_1');
            $table->dropColumn('titulo_2');
            $table->dropColumn('titulo_3');
            $table->dropColumn('titulo_4');
        });
    }
}
