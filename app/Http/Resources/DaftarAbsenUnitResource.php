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
         if ($this->status_absen == 1) {
            $key = "jam_jadwal";
            $value = $this->jam_masuk;
        } else {
            $key = "jam_jadwal";
            $value = $this->jam_keluar;
        } 
        return [
            'id'           => $this->id,
            'kode_pegawai' => $this->kd_pegawai,
            'nama_pegawai' => $this->nama_pegawai,
            'tanggal'      => tanggal($this->tanggal),
            'jam'          => waktu($this->jam),
            $key           => waktu($value),
            'jam_absen'    => waktu($this->jam),
            'selisih'      => selisih($value, $this->jam),
            'keterangan'   => keterangan($value, $this->jam, $this->status_absen, $this->kode_shift),
            'status_absen' => absensi($this->status_absen),
            'generate_key' => generateKey($this->generate_key),
            'nama_unit'    => $this->nama_sub_unit,
        ];
    }
}
