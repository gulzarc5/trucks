<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckImage extends Model
{
    protected $table = "truck_images";
    protected $primaryKey = "id";

    protected $fillable = [
        'image', 'truck_id',
    ];
}
