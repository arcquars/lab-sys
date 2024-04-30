<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTecnicaTextNumToHistoquimicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histoquimicas', function (Blueprint $table) {
            $table->integer('tecnica_text_num')->default(0);
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
            $table->dropColumn('tecnica_text_num');
        });
    }
}
