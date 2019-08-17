<?php

use Illuminate\Database\Seeder;
use App\KelasUser;

class KelasUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new KelasUser;
        $data->user_id = 4;
        $data->kelas_id = 1;
        $data->tahun_id = 1;
        $data->save();
    }
}
