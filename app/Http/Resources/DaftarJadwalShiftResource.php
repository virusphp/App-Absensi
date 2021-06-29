<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DaftarJadwalShiftResource extends JsonResource
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
            'tanggal'       => $this->tanggal,
            'kode_shift'    => $this->kode_shift,
            'nama_shift'    => $this->nama_shift,
            'jam_masuk'     => waktu($this->jam_masuk),
            'jam_keluar'    => waktu($this->jam_keluar),
        ];
    }
}
