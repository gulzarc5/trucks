<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $table = "trucks";
    protected $primaryKey = "id";

    protected $fillable = [
        'truck_type', 'weight_id','owner_id','driver_id','source','image', 'status'
    ];
}
