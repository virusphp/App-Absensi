<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PegawaiCollection extends ResourceCollection
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
            'pegawai' => $this->collection->map(function($pegawai) use ($request) {
                return (new PegawaiResource($pegawai))->toArray($request);
            })
        ];
    }
}
