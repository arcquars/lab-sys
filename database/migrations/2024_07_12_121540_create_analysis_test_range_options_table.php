<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisTestRangeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_test_range_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('initial');
            $table->double('end');
            $table->double('age_initial')->nullable();
            $table->double('age_end')->nullable();
            $table->string('gender');
            $table->boolean('deleted')->default(false);
            $table->bigInteger('user_id')->nullable(true);
            $table->timestamps();
        });

        Schema::table('a_test_range_options', function (Blueprint $table) {
            $table->bigInteger('a_test_range_id')->unsigned();
            $table->foreign('a_test_range_id')->references('id')->on('a_test_ranges');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_test_range_options');
    }
}
