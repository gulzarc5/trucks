<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journey extends Model
{
    protected $table = "journey";
    protected $primaryKey = "id";

    protected $fillable = [
        'truck_id', 'owner_id','bid_id','order_id','driver_id','journey_start_date', 'journey_end_date', 'status'
    ];

    public function truck()
    {
        return $this->belongsTo('App\Models\Truck', 'truck_id','id');
    }
    public function driver()
    {
        return $this->belongsTo('App\Models\User', 'driver_id','id');
    }
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id','id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\OrderCustomer', 'order_id','id');
    }
}
