<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Traits\TraitBiodata;

class AkunResource extends JsonResource
{
    use TraitBiodata;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $nama = $this->getNama($this);
        $foto = $this->getFoto($this->kd_pegawai, $this->foto);

        $unit = [
            'kode_unit' => $this->kd_sub_unit,
            'nama_unit' => $this->nama_sub_unit
        ];

        return [
            'akun' => [
                'mac_address'   => $this->mac_address,
                'nama_device'   => $this->device,
                'kode_pegawai'  => $this->kd_pegawai,
                'nama_pegawai'  => $nama,
                'tempat_lahir'  => $this->tempat_lahir,
                'tanggal_lahir' => tanggal($this->tgl_lahir),
                'unit'          => $unit,
                'foto'          => $foto,
                'created_at'    => $this->created_at,
                'updated_at'    => $this->updated_at,
            ],
            'api_token' => $this->api_token,
        ];
    }
}
