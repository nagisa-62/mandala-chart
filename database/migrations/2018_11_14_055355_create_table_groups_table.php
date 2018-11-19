<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('table_number');
            $table->unsignedInteger('chart_id');
            $table->timestamps();

            $table->foreign('chart_id')->references('id')->on('charts')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_groups');
    }
}
