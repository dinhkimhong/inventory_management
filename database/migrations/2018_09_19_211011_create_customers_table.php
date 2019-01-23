<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_number')->unique();
            $table->string('customer_name',100);
            $table->string('billing_address',150);
            $table->string('billing_province',30);
            $table->string('ship_to_address',150)->nullable();
            $table->string('ship_to_province',30)->nullable();
            $table->string('country_code',3)->unsign();
            $table->string('tel',30);
            $table->string('fax',30)->nullable();
            $table->string('website',50)->nullable();
            $table->string('contact',30)->nullable();
            $table->string('title',10)->unsign()->nullable();
            $table->string('email',50)->nullable();
            $table->boolean('gst');
            $table->string('gst_number',20)->nullable();           
            $table->boolean('pst');
            $table->string('pst_number',20)->nullable(); 
            $table->boolean('hst');
            $table->string('hst_number',20)->nullable(); 
            $table->float('discount',3,2)->nullable();
            $table->string('sales_person',30)->nullable();
            $table->string('customer_class',1)->unsign()->nullable();
            $table->integer('created_by')->unsigned();            
            $table->timestamps();
            $table->foreign('country_code')->references('country_code')->on('countries');
            $table->foreign('title')->references('title')->on('titles');
            $table->foreign('customer_class')->references('customer_class')->on('customer_classes');
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
        Schema::dropIfExists('customers');
    }
}
