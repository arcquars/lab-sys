<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class AddPathImageAndIntencidadToMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marcadors', function (Blueprint $table) {
            $table->string('path_image')->default(null);
            $table->text('intensidad')->default(null)->nullable(true);
            DB::statement("ALTER TABLE marcadors modify resultado text");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marcadors', function (Blueprint $table) {
            $table->dropColumn('path_image');
            $table->dropColumn('intensidad');
        });
    }
}
