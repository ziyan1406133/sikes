<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function kelas_user(){
        return $this->belongsTo('App\KelasUser', 'kelas_tahun_id');
    }
    
    public function bulan(){
        return $this->belongsTo('App\Bulan');
    }

    public function bayar() {
        return $this->hasMany('App\SppBayar', 'spp_id');
    }
}
