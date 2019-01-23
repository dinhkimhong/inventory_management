<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create(['unit'=>'M', 'unit_description'=>'Meter']);
		Unit::create(['unit'=>'Kg', 'unit_description'=>'Kilogram']);
		Unit::create(['unit'=>'G', 'unit_description'=>'Gram']);
		Unit::create(['unit'=>'EA', 'unit_description'=>'Each']);
		Unit::create(['unit'=>'PC', 'unit_description'=>'Piece']);
    }
}
