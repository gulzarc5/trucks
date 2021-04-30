<?php

namespace App\Http\Resources\Truck;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Truck\TruckImagesResource;
class TruckResource extends JsonResource
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
            'truck_number' => $this->truck_number,
            'image' => $this->image,
            'status' => $this->status,
            'owner_id' => $this->owner_id,
            'owner_name' => !empty($this->owner_id) && isset($this->owner->name) ? $this->owner->name : null,
            'source_id' => $this->source,
            'source_name' => !empty($this->source) && isset($this->sourceCity->name) ? $this->sourceCity->name : null,
            'truck_type' => $this->truck_type,
            'truck_type_name' => !empty($this->truck_type) && isset($this->truckType->name) ? $this->truckType->name : null,
            'truck_capacity_id' => $this->weight_id,
            'truck_capacity' => !empty($this->weight_id) && isset($this->capacity->weight) ? $this->capacity->weight : null,
            'created_at' => $this->created_at,
            'service_area_list' => isset($this->serviceCity) ? TruckServiceAreaResource::collection($this->serviceCity) : [],
            'truck_images' => TruckImagesResource::collection($this->images),
        ];
    }
}
