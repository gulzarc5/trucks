<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    protected $table = "bids";
    protected $primaryKey = "id";

    protected $fillable = [
        'order_id', 'client_id', 'bid_amount','status'
    ];

    public function client()
    {
       return $this->belongsTo('App\Models\User','client_id','id');
    }
    public function order()
    {
       return $this->belongsTo('App\Models\OrderCustomer','order_id','id');
    }
}
