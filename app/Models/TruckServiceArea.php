<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckServiceArea extends Model
{
    protected $table = "truck_service_area";
    protected $primaryKey = "id";

    protected $fillable = [
        'truck_id', 'service_area'
    ];
}
