<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $table = "journey";
    protected $primaryKey = "id";

    protected $fillable = [
        'truck_id', 'order_id', 'status'
    ];
}
