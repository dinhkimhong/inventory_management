<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbound_details', function (Blueprint $table) {
            $table->increments('number')->unique();
            $table->integer('inbound_number')->unsigned();
            $table->integer('material_number')->unsigned();
            $table->float('receipt_quantity',8,2);
            $table->string('batch_number');
            $table->foreign('material_number')->references('material_number')->on('materials');
            $table->foreign('inbound_number')->references('inbound_number')->on('inbounds');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbound_details');
    }
}
