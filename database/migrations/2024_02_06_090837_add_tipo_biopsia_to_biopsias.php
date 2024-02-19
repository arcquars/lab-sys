<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoBiopsiaToBiopsias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biopsias', function (Blueprint $table) {
            $table->string('tipo_biopsia', 250)->default(null)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biopsias', function (Blueprint $table) {
            $table->dropColumn('tipo_biopsia');
        });
    }
}
