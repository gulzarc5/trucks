<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerJourneyListResource extends JsonResource
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
            'truck_id' => isset($this->truck->id) ? $this->truck->id : null,
            'truck_number' => isset($this->truck->truck_number) ? $this->truck->truck_number : null,
            'driver_name' => isset($this->driver->name) ? $this->driver->name : null,
            'source_city' => isset($this->order->sourceCity->name) ? $this->order->sourceCity->name : null,
            'destination_city' => isset($this->order->destinationCity->name) ? $this->order->destinationCity->name : null,
            'journey_status' => $this->status,
        ];;
    }
}
