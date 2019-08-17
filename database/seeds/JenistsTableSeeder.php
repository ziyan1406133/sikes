<?php

use Illuminate\Database\Seeder;
use App\Jenist;

class JenistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Jenist;
        $data->nama = 'SPP';
        $data->jenis = 'Rutin';
        $data->nominal = '100000';
        $data->save();

    }
}
