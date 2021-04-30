<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\ClientProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerOrderListResource extends JsonResource
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
            'bid_approval_status' => $this->bid_approval_status,
            'amount' => $this->amount,
            'adv_amount' => $this->adv_amount,
            'journey_status' => $this->journey_status,
            'payment_type' => $this->payment_type,
            'payment_status' => $this->payment_status,
            'client_details' => $this->bid_status == 3 ? new ClientProfileResource($this->client) : null,
        ];
    }
}
