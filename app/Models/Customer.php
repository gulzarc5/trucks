<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = "customer";
    protected $primaryKey = "id";

    protected $fillable = [
         'name', 'mobile','email','gender', 'state','city','address','pin','otp','api_token','status','user_type','profile_status','password',
    ];
    protected $hidden = [
        'password',
    ];
    public function stateName()
    {
        return $this->hasOne('App\Models\State',$this->primaryKey,'state');
    }

    public function cityName()
    {
        return $this->hasOne('App\Models\City',$this->primaryKey,'city');
    }
}
