<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEscamosasGlandularesMetaplasiaBethesdaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bethesda', function (Blueprint $table) {
            $table->boolean('escamosas')->default(0);
            $table->boolean('glandulares')->default(0);
            $table->boolean('metaplasia')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bethesda', function (Blueprint $table) {
            $table->dropColumn('escamosas');
            $table->dropColumn('glandulares');
            $table->dropColumn('metaplasia');
        });
    }
}
