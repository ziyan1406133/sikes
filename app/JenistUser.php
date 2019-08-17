<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenistUser extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function jenist(){
        return $this->belongsTo('App\Jenist');
    }
    
    public function bulan(){
        return $this->belongsTo('App\Bulan');
    }

    public function bayar() {
        return $this->hasMany('App\JenistUserBayar', 'tagihan_id');
    }
}
