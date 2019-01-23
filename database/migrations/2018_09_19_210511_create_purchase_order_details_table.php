<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->increments('number')->unique();
            $table->integer('po_number')->unsigned();
            $table->integer('material_number')->unsigned();
            $table->float('quantity',8,2);
            $table->float('amount',8,2);
            $table->float('import_duty',8,2);
            $table->float('freight_handling_cost',8,2);
            $table->foreign('po_number')->references('po_number')->on('purchase_orders');
            $table->foreign('material_number')->references('material_number')->on('materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_details');
    }
}
