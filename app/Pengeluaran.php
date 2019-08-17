<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    public function jenisk(){
        return $this->belongsTo('App\Jenisk');
    }
}
