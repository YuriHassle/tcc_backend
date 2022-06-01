<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $items = array_column($this->items->toArray(), 'id');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'items' => $items,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
