<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisTestGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_test_groups', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable(true);
            $table->boolean('deleted')->default(false);
            $table->integer('sorted')->default(0);
            $table->bigInteger('user_id')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_test_groups');
    }
}
