<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    
    public function user(){
        return $this->belongsToMany('App\User', 'kelas_user', 'kelas_id', 'user_id');
    }
    

    public function tahun(){
        return $this->belongsToMany('App\TahunAjaran', 'kelas_user', 'kelas_id', 'tahun_id');
    }
}
