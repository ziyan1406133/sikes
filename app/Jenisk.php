<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenisk extends Model
{
    public function pengeluaran(){
        return $this->HasMany('App\Pengeluaran');
    }
    
    public function jenus(){
        return $this->HasMany('App\Pengeluaran');
    }
}
