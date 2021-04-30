<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    protected $table = "order_customer";
    protected $primaryKey = "id";

    protected $fillable = [
        'customer_id', 'truck_type_id','material','source_city_id','destination_city_id','weight_id','no_of_trucks','schedule_date' ,'bid_status','bid_approval_status','payment_type','payment_status','payment_request_id','payment_id','amount','adv_amount','assigned_client_id'
    ];

    public function client()
    {
       return $this->belongsTo('App\Models\User','assigned_client_id','id');
    }
    public function customer()
    {
       return $this->belongsTo('App\Models\Customer','customer_id','id');
    }
    public function truckType()
    {
       return $this->belongsTo('App\Models\TruckType','truck_type_id','id');
    }
    public function sourceCity()
    {
       return $this->belongsTo('App\Models\City','source_city_id','id');
    }
    public function destinationCity()
    {
       return $this->belongsTo('App\Models\City','destination_city_id','id');
    }
    public function weight()
    {
       return $this->belongsTo('App\Models\TruckWeight','weight_id','id');
    }
   public function bidTotal()
   {
      return $this->hasMany('App\Models\Bids','order_id','id');
   }
   public function journey()
   {
      return $this->hasMany('App\Models\Journey','order_id','id');
   }
}
