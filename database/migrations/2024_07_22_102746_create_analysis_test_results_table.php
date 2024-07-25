<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_test_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('result')->nullable();
            $table->string('test_text')->nullable();

            $table->bigInteger('a_test_id')->nullable();
            $table->bigInteger('user_id')->nullable();

            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });

        Schema::table('a_test_results', function (Blueprint $table) {
            $table->bigInteger('analysis_id')->unsigned();
            $table->foreign('analysis_id')->references('id')->on('analisis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_test_results');
    }
}
