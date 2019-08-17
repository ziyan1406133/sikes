<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenistUserBayar extends Model
{
    protected $table = 'tagihan_bayar';
    
    public function jenistuser(){
        return $this->belongsTo('App\JenistUser', 'tagihan_id');
    }
}
