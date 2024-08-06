<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisTestGenericsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_test_generics', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->boolean('deleted')->default(false);
            $table->bigInteger('user_id')->nullable(true);

            $table->timestamps();
        });

        Schema::table('a_test_generics', function (Blueprint $table) {
            $table->bigInteger('a_test_id')->unsigned();
            $table->foreign('a_test_id')->references('id')->on('a_tests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_test_generics');
    }
}
