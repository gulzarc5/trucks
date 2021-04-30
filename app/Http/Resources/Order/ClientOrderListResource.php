<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientOrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'truck_type_name' => isset($this->truckType->name) ? $this->truckType->name : '',
            'source_city' => isset($this->sourceCity->name) ? $this->sourceCity->name : '',
            'destination_city' => isset($this->destinationCity->name) ? $this->destinationCity->name : '',
            'weight' => isset($this->weight->weight) ? $this->weight->weight." MT" : '',
            'no_of_trucks' => $this->no_of_trucks,
            'schedule_date' => $this->schedule_date,
            'bid_status' => $this->bid_status,
            'is_bid' => $this->is_bid,
        ];
    }
}
