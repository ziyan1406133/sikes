<?php

use Illuminate\Database\Seeder;
use App\Kelas;

class KelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new Kelas;
        $data->nama = 'X IPA';
        $data->save();
        
        $data = new Kelas;
        $data->nama = 'XI IPA';
        $data->save();
        
        $data = new Kelas;
        $data->nama = 'XII IPA 1';
        $data->save();
        
        $data = new Kelas;
        $data->nama = 'XI IPA 2';
        $data->save();
        
        $data = new Kelas;
        $data->nama = 'XII IPA 3';
        $data->save();
    }
}
