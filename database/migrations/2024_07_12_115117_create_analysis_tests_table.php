<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_tests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->double('price', 10, 2);
            $table->string('type');
            $table->boolean('deleted')->default(false);
            $table->bigInteger('user_id')->nullable(true);
            $table->timestamps();
        });

        Schema::table('a_tests', function (Blueprint $table) {
            $table->bigInteger('a_test_group_id')->unsigned();
            $table->foreign('a_test_group_id')->references('id')->on('a_test_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_tests');
    }
}
