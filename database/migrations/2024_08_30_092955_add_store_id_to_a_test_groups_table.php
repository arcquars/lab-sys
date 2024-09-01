<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreIdToATestGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_test_groups', function (Blueprint $table) {
            $table->bigInteger('parent_id')->nullable()->unsigned();
            $table->index('parent_id')->nullable();
            $table->foreign('parent_id')->nullable()->references('id')->on('a_test_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('a_test_groups', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
