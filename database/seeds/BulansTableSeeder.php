<?php

use Illuminate\Database\Seeder;
use App\Bulan;

class BulansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bulan = new Bulan;
        $bulan->nama = 'Januari';
        $bulan->save();

        $bulan = new Bulan;
        $bulan->nama = 'Februari';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'Maret';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'April';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'Mei';
        $bulan->save();

        $bulan = new Bulan;
        $bulan->nama = 'Juni';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'Juli';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'Agustus';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'September';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'Oktober';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'November';
        $bulan->save();
        
        $bulan = new Bulan;
        $bulan->nama = 'Desember';
        $bulan->save();
    }
}
