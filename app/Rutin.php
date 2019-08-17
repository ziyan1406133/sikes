<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rutin extends Model
{
    public function bulan(){
        return $this->belongsTo('App\Bulan');
    }
}
