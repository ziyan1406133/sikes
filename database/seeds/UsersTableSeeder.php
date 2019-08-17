<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Tata Usaha';
        $user->no_induk = '19850330 2003121 002';
        $user->email = 'admin@sikes.test';
        $user->username = 'admin';
        $user->role = 'Admin';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User;
        $user->name = 'Aji Kurniawan, M. Pd.';
        $user->no_induk = '19850330 2003121 001';
        $user->email = 'kepsek@sikes.test';
        $user->username = 'kepsek';
        $user->role = 'Kepala Sekolah';
        $user->password = Hash::make('password');
        $user->save();
        
        $user = new User;
        $user->name = 'Utami Wulandari, S.Pd.';
        $user->no_induk = '19850330 2003121 003';
        $user->email = 'bendahara@sikes.test';
        $user->username = 'bendahara';
        $user->role = 'Bendahara';
        $user->password = Hash::make('password');
        $user->save();
        
        $user = new User;
        $user->name = 'Subagja';
        $user->no_induk = '1484325';
        $user->username = 'subagja';
        $user->role = 'Siswa';
        $user->password = Hash::make('password');
        $user->save();
    }
}
