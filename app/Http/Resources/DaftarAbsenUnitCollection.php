<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DaftarAbsenUnitCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'list_absen_unit' => $this->collection->map(function($absen) use ($request) {
                return (new DaftarAbsenUnitResource($absen))->toArray($request);
            })
        ];
    }
}
