<?php

namespace Modules\City\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Province\Transformers\ProvinceResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'province' => new ProvinceResource($this->whenLoaded('province'))
        ];
    }
}
