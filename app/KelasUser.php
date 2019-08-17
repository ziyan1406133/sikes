<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelasUser extends Model
{
    protected $table = 'kelas_user';

    public function spp(){
        return $this->hasMany('App\Spp', 'kelas_tahun_id');
    }

    public function tahun() {
        return $this->belongsTo('App\TahunAjaran');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function kelas() {
        return $this->belongsTo('App\Kelas');
    }
}
