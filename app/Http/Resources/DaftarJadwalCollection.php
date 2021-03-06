<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DaftarJadwalCollection extends ResourceCollection
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
            'jadwal_non_shift' => $this->collection->map(function($absen) use ($request) {
                return (new DaftarJadwalResource($absen))->toArray($request);
            })
        ];
    }
}
