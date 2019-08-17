<?php

use Illuminate\Database\Seeder;
use App\Uang;

class UangsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Uang;
        $data->save();
    }
}
