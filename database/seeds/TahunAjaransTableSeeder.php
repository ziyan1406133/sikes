<?php

use Illuminate\Database\Seeder;
use App\TahunAjaran;

class TahunAjaransTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bulan = new TahunAjaran;
        $bulan->tahun = '2018/2019';
        $bulan->save();
    }
}
