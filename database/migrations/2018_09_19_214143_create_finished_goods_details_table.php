<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishedGoodsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_goods_details', function (Blueprint $table) {
            $table->increments('number');
            $table->integer('finished_number')->unsigned();
            $table->integer('semi_number')->unsigned();
            $table->integer('semi_quantity');
            $table->string('remark',100);
            $table->foreign('finished_number')->references('finished_number')->on('finished_goods');
            $table->foreign('semi_number')->references('semi_number')->on('semis');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finished_goods_details');
    }
}
