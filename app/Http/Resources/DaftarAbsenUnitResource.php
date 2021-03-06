<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DaftarAbsenUnitResource extends JsonResource
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
            'id'           => $this->id,
            'nama_pegawai' => $this->nama_pegawai,
            'tanggal'      => tanggal($this->tanggal),
            'jam'          => waktu($this->jam),
            'status_absen' => absensi($this->status_absen),
            'generate_key' => generateKey($this->generate_key),
            'nama_unit'    => $this->nama_sub_unit,
        ];
    }
}
