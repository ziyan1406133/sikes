<?php

use Illuminate\Database\Seeder;
use App\Jenisk;

class JenisksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Jenisk;
        $data->nama = 'Pengembangan Perpustakaan';
        $data->save();
        
        $data = new Jenisk;
        $data->nama = 'Kegiatan Pembelajaran dan Ekskul';
        $data->save();
        
        $data = new Jenisk;
        $data->nama = 'Kegiatan Evaluasi Pembelajaran';
        $data->save();
        
        $data = new Jenisk;
        $data->nama = 'Pengelolaan Sarana dan Prasarana';
        $data->save();
        
        $data = new Jenisk;
        $data->nama = 'Langganan Daya dan Jasa';
        $data->save();
        
        $data = new Jenisk;
        $data->nama = 'Pembayaran Honor';
        $data->save();
    }
}
