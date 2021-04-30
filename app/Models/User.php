<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "user";
    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'mobile','email','password','owner_id','user_type','driving','state','city','address','pin','otp','api_token', 'status','image'
    ];
    protected $hidden = [
        'password',
    ];

    public function state_data()
    {
        return $this->belongsTo('App\Models\State','state',$this->primaryKey);
    }

    public function city_data()
    {
        return $this->belongsTo('App\Models\City','city',$this->primaryKey);
    }
    public function trucks()
    {
        return $this->hasMany('App\Models\Truck','owner_id',$this->primaryKey);
    }

    public function drivers()
    {
        return $this->hasMany('App\Models\User','owner_id',$this->primaryKey);
    }

    public function driverOwner()
    {
        return $this->belongsTo('App\Models\User','owner_id',$this->primaryKey);
    }
    public function driverTruck()
    {
        return $this->hasOne('App\Models\Truck','driver_id','id');
    }

}
