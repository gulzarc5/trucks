<?php

namespace App\Http\Resources\Truck;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Truck\TruckImagesResource;
class TruckServiceAreaResource extends JsonResource
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
            'city_id' => $this->service_area,
            'city_name' => isset($this->city->name) ? $this->city->name : null,
            'is_source' => $this->is_source,
            'status' => $this->status,
        ];
    }
}
