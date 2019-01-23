<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('po_number')->unique();
            $table->string('delivery_term',3);
            $table->string('delivery_place',20)->nullable();
            $table->integer('vendor_number')->unsigned();
            $table->string('contact',30)->nullable();
            $table->string('email',30)->nullable();
            $table->float('total_amount',8,2)->nullable();
            $table->float('total_import_duty',8,2)->nullable();
            $table->float('total_freight_handling_cost',8,2)->nullable();
            $table->integer('created_by')->unsigned();
            $table->timestamps();
            $table->foreign('vendor_number')->references('vendor_number')->on('vendors');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
