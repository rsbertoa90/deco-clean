<?php

use Illuminate\Database\Seeder;
use App\Seminar;
class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seminar::create(['title'=>'Tortas altas','description'=>'test data']);
        Seminar::create(['title'=>'Multitecnicas 1','description'=>'test data']);
        Seminar::create(['title'=>'Multitecnicas 2','description'=>'test data']);
        Seminar::create(['title'=>'Bordes perfectos','description'=>'test data']);
    }
}
