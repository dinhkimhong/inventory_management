<?php

use Illuminate\Database\Seeder;
use App\CustomerClass;
class CustomerClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerClass::create(['customer_class'=>'A','customer_class_description'=>'Platinum']);
        // CustomerClass::create(['customer_class'=>'C','customer_class_description'=>'Gold']);
        // CustomerClass::create(['customer_class'=>'D','customer_class_description'=>'Silver']);
    }
}
