<?php

namespace App\Http\Resources\Journey;

use Illuminate\Http\Resources\Json\JsonResource;

class JourneyListResource extends JsonResource
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
            'order_id' => $this->order_id,
            'truck_id' => isset($this->truck->id) ? $this->truck->id : null,
            'truck_number' => $this->truck_no,
            'driver_name' => $this->driver_name,
            'source_city' => isset($this->order->sourceCity->name) ? $this->order->sourceCity->name : null,
            'destination_city' => isset($this->order->destinationCity->name) ? $this->order->destinationCity->name : null,
            'journey_status' => $this->status,
            'customer_details' => isset($this->order->customer) ? new CustomerResource($this->order->customer) : null,
        ];;
    }
}
