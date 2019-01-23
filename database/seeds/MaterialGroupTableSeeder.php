<?php

use Illuminate\Database\Seeder;
use App\MaterialGroup;

class MaterialGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaterialGroup::create(['material_group_id'=>'IN', 'material_group'=>'industry']);
        MaterialGroup::create(['material_group_id'=>'PD', 'material_group'=>'production']);
        MaterialGroup::create(['material_group_id'=>'AC', 'material_group'=>'accessory']);
    }
}
