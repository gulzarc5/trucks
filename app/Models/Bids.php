<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    protected $table = "bids";
    protected $primaryKey = "id";

    protected $fillable = [
        'order_id', 'client_id', 'bid_amount','status','truck_details',
        'driver_details'
    ];

    public function client()
    {
       return $this->belongsTo('App\Models\User','client_id','id');
    }

    public function journey()
    {
        return $this->hasMany('App\Models\Journey','bid_id','id');
    }
    public function order()
    {
       return $this->belongsTo('App\Models\OrderCustomer','order_id','id');
    }
}
