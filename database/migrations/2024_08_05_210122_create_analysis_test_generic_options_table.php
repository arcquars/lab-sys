<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysisTestGenericOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_test_generic_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference');
            $table->double('age_initial')->nullable();
            $table->double('age_end')->nullable();
            $table->string('gender');
            $table->boolean('deleted')->default(false);
            $table->bigInteger('user_id')->nullable(true);
            $table->timestamps();
        });

        Schema::table('a_test_generic_options', function (Blueprint $table) {
            $table->bigInteger('a_test_generic_id')->unsigned();
            $table->foreign('a_test_generic_id')->references('id')->on('a_test_generics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_test_generic_options');
    }
}
