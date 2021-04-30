<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckWeight extends Model
{
    protected $table = "truck_weight";
    protected $primaryKey = "id";

    protected $fillable = [
        'weight'
    ];
}
