<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $table = "trucks";
    protected $primaryKey = "id";

    protected $fillable = [
        'truck_type', 'weight_id','owner_id','driver_id','source','image', 'status','truck_number'
    ];

    public function capacity()
    {
        return $this->belongsTo('App\Models\TruckWeight','weight_id',$this->primaryKey);
    }
    public function owner()
    {
        return $this->belongsTo('App\Models\User','owner_id',$this->primaryKey);
    }
    public function driver()
    {
        return $this->belongsTo('App\Models\User','driver_id',$this->primaryKey);
    }
    public function sourceCity()
    {
        return $this->belongsTo('App\Models\City','source',$this->primaryKey);
    }
    public function images()
    {
        return $this->hasMany('App\Models\TruckImage','truck_id',$this->primaryKey);
    }
}
