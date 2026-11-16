<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustrialExhibitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industrial_exhibition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name', 250);
            $table->date('rehearsal_date');
            $table->date('manufacture_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('lot_number', 250)->nullable();
            $table->unsignedBigInteger('analisis_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('analisis_id')->references('id')->on('analisis')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('industrial_exhibition');
    }
}
