<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImage123ForHistoquimicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histoquimicas', function (Blueprint $table) {
            $table->string('imagen1')->nullable();
            $table->string('imagen2')->nullable();
            $table->string('imagen3')->nullable();
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
            $table->dropColumn('imagen1');
            $table->dropColumn('imagen2');
            $table->dropColumn('imagen3');
        });
    }
}
