<?php

use Illuminate\Database\Seeder;
use App\Title;
class TitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Title::create(['title'=>'Mr','title_description'=>'Mr']);
        Title::create(['title'=>'Mrs','title_description'=>'Mrs']);
        Title::create(['title'=>'Ms','title_description'=>'Ms']);
    }
}
