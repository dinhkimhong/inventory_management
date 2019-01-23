<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(['department_description'=>'Purchasing']);
        Department::create(['department_description'=>'Marketing']);
        Department::create(['department_description'=>'Executive']);
        Department::create(['department_description'=>'Sales']);
        Department::create(['department_description'=>'Customer Service']);
    }
}
