<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisTestRangeNoOrderOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_test_range_no_order_options', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('gender');
            $table->double('age_initial')->nullable();
            $table->double('age_end')->nullable();

            $table->string('initial_text')->nullable();
            $table->double('initial_value')->nullable();
            $table->boolean('initial_bookmark')->nullable();
            $table->string('end_text')->nullable();
            $table->double('end_value')->nullable();
            $table->boolean('end_bookmark')->nullable();

            $table->boolean('deleted')->default(false);
            $table->bigInteger('user_id')->nullable(true);

            $table->timestamps();
        });

        Schema::table('a_test_range_no_order_options', function (Blueprint $table) {
            $table->bigInteger('a_test_range_no_order_id')->unsigned();
            $table->foreign('a_test_range_no_order_id')->references('id')->on('a_test_range_no_orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_test_range_no_order_options');
    }
}
