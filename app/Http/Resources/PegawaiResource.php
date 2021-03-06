<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PegawaiResource extends JsonResource
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
            'nip'            => $this->nip,
            'kode_pegawai'   => $this->kd_pegawai,
            'nama_pegawai'   => $this->nama_pegawai,
            'tanggal_lahir'  => $this->tgl_lahir,
            'gelar_depan'    => $this->gelar_depan,
            'gelar_belakang' => $this->gelar_belakang,
            'unit'           => $this->nama_sub_unit,
        ];
    }
}
