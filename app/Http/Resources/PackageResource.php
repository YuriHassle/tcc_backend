<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $services = array_column($this->services->toArray(), 'id');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'max_guests' => $this->max_guests,
            'price' => $this->price,
            'services' => $services,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
