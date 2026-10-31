<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreordenCustomTestsTable extends Migration
{
    public function up()
    {
        Schema::create('preorden_custom_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pre_order_id');
            $table->text('description');
            $table->timestamps();

            $table->foreign('pre_order_id')->references('id')->on('pre_orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('preorden_custom_tests');
    }
}
