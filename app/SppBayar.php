<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SppBayar extends Model
{
    protected $table = 'spp_bayar';
    
    public function spp(){
        return $this->belongsTo('App\Spp');
    }
}
