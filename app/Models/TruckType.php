<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckType extends Model
{
    protected $table = "truck_type";
    protected $primaryKey = "id";

    protected $fillable = [
        'name', 'status',
    ];
}
