<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";
    protected $primaryKey = "id";

    protected $fillable = [
         'name', 'mobile','email','state','city','address','pin','otp','api_token','status'
    ];
}
