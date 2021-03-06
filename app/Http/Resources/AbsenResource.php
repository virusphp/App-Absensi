<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
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
            'absen' => [
                'tanggal'      => tanggal($this->tanggal),
                'jam'          => waktu($this->jam),
                'status_absen' => $this->status_absen
            ]
        ];
    }
}
