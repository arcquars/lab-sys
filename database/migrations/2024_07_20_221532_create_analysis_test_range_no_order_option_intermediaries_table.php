<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisTestRangeNoOrderOptionIntermediariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_test_rno_option_intermediaries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('range_name');
            $table->double('initial_range');
            $table->double('end_range');
            $table->boolean('bookmark');

            $table->boolean('deleted')->default(false);

            $table->timestamps();
        });

        Schema::table('a_test_rno_option_intermediaries', function (Blueprint $table) {
            $table->bigInteger('order_option_id')->unsigned();
            $table->foreign('order_option_id')->references('id')->on('a_test_range_no_order_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_test_rno_option_intermediaries');
    }
}
