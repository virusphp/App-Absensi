<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HasilAssesmentResource extends JsonResource
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
            'kode_pegawai'      => $this->kode_pegawai,
            'kode_assesment'    => $this->kode_assesment,
            'tanggal_assesment' => $this->tanggal_assesment,
            'score'             => $this->score,
        ];
    }
}
