<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semi_details', function (Blueprint $table) {
            $table->increments('number')->unique();
            $table->integer('semi_number')->unsigned();
            $table->integer('material_number')->unsigned();
            $table->float('quantity_raw',8,2);
            $table->float('price_raw',8,2);
            $table->string('remark',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semi_details');
    }
}
