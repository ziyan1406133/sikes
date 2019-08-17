<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function kelas(){
        return $this->belongsToMany('App\Kelas', 'kelas_user', 'user_id', 'kelas_id')->orderBy('tahun_id', 'asc');
    }
    
    public function currentclass(){
        return $this->belongsToMany('App\Kelas', 'kelas_user', 'user_id', 'kelas_id')->orderBy('id', 'desc')->limit(1);
    }
    
    public function tahun(){
        return $this->belongsToMany('App\Tahun', 'kelas_user', 'user_id', 'tahun_id');
    }
    
    public function bulan(){
        return $this->belongsToMany('App\Bulan', 'kelas_user', 'user_id', 'tahun_id');
    }
    
    public function tagihan(){
        return $this->belongsToMany('App\Jenist', 'jenist_users', 'user_id', 'jenist_id');
    }
    
    public function tagihan1(){
        return $this->hasMany('App\Jenist');
    }

    public function spp(){
        return $this->hasMany('App\Spp');
    }
    
    public function kelas1(){
        return $this->hasMany('App\KelasUser')->orderBy('tahun_id', 'asc');
    }

}
