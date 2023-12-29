<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSizeTextMarkerToMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histoquimicas', function (Blueprint $table) {
            $table->integer('size_texto_marcadores')->default(null);
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
            $table->dropColumn('size_texto_marcadores');
        });
    }
}
