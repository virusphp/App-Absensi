<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DaftarJadwalResource extends JsonResource
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
            'kode_pegawai'  => $this->kode_pegawai,
            'nama_pegawai'  => $this->nama_pegawai,
            'kode_shift'    => $this->kode_shift,
            'berlaku_mulai' => $this->berlaku_mulai,
            'jam_masuk'     => $this->jam_masuk,
            'jam_keluar'    => $this->jam_keluar,
            'status'        => status($this->status)
        ];
    }
}
