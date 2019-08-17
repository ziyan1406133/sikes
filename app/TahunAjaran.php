<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    public function kelas(){
        return $this->belongsToMany('App\Kelas', 'kelas_user', 'tahun_id', 'kelas_id');
    }
    
    public function user(){
        return $this->belongsToMany('App\User', 'kelas_user', 'tahun_id', 'tahun_id');
    }
}
