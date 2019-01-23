<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('vendor_number')->unique();
            $table->string('vendor_name',50);
            $table->string('address_1',100);
            $table->string('province_1',50);
            $table->string('address_2',100)->nullable();
            $table->string('province_2',50)->nullable();
            $table->string('country_code',20)->unsign();
            $table->string('business_number',20)->nullable();
            $table->string('website')->nullable();
            $table->integer('tel');
            $table->integer('fax')->nullable();
            $table->string('contact',30)->nullable();
            $table->string('title',10)->nullable()->unsign();
            $table->string('department',20)->nullable();
            $table->string('email',50)->nullable();
            $table->string('created_by',30);
            $table->timestamps();
            $table->foreign('country_code')->references('country_code')->on('countries');
            $table->foreign('title')->references('title')->on('titles'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
