<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "user";
    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'mobile','email','owner_id','user_type','driving','state','city','address','pin','otp','api_token', 'status','image'
    ];

    
}
