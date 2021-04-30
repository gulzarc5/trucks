<?php

namespace App\Http\Resources\Bid;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientBidListResource extends JsonResource
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
            'order_id' => $this->order->id ?? null,
            'truck_type_name' => isset($this->order->truckType->name) ? $this->order->truckType->name : '',
            'source_city' => isset($this->order->sourceCity->name) ? $this->order->sourceCity->name : '',
            'destination_city' => isset($this->order->destinationCity->name) ? $this->order->destinationCity->name : '',
            'weight' => isset($this->order->weight->weight) ? $this->order->weight->weight." MT" : '',
            'no_of_trucks' => isset($this->order->no_of_trucks) ? $this->order->no_of_trucks : '',
            'schedule_date' => isset($this->order->schedule_date) ? $this->order->schedule_date : '',
            'bid_amount' => $this->bid_amount,
            'status' => $this->status,
            'order_status' => $this->order->bid_status ?? 1,
            'journey_count' => $this->journey->count() ?? 0,
            'customer_details' => $this->status == 2 ? $this->order->customer : null ,
        ];;
    }
}
