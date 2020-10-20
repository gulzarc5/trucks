<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    protected $table = "order_customer";
    protected $primaryKey = "id";

    protected $fillable = [
        'customer_id', 'truck_type','material','source','destination','weight','no_of_trucks','schedule_date' ,'bid_status','truck_id_assigned','driver_id_assigned','assigned_date','assigned_status'
    ];
}
