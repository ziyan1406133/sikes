<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenist extends Model
{
    public function jenus(){
        return $this->hasMany('App\JenistUser');
    }
}
