<?php

use Illuminate\Database\Seeder;
use App\DeliveryTerm;

class DeliveryTermTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryTerm::create(['delivery_term'=>'FCA','delivery_term_description'=>'Free Carrier']);
        DeliveryTerm::create(['delivery_term'=>'FAS','delivery_term_description'=>'Free Alongside Ship']);
        DeliveryTerm::create(['delivery_term'=>'FOB','delivery_term_description'=>'Free on Board']);
        DeliveryTerm::create(['delivery_term'=>'CFR','delivery_term_description'=>'Cost and Freight']);
        DeliveryTerm::create(['delivery_term'=>'CIF','delivery_term_description'=>'Cost, Insurance and Freight']);
        DeliveryTerm::create(['delivery_term'=>'CPT','delivery_term_description'=>'Carriage Paid to']);
        DeliveryTerm::create(['delivery_term'=>'CIP','delivery_term_description'=>'Carriage and Insurance Paid To']);
        DeliveryTerm::create(['delivery_term'=>'DAT','delivery_term_description'=>'Delivered at Terminal']);
        DeliveryTerm::create(['delivery_term'=>'DAP','delivery_term_description'=>'Delivered at Place']);
        DeliveryTerm::create(['delivery_term'=>'DDP','delivery_term_description'=>'Delivered Duty Paid']);
        DeliveryTerm::create(['delivery_term'=>'D2D','delivery_term_description'=>'Door to Door']);
    }
}
