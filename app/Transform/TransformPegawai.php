<?php

namespace App\Transform;

class TransformPegawai extends Transform
{
    public function mapperAll($table)
    {
        foreach ($table as $value) {
            $data["pegawai"][] = [
                'nip'            => $value->nip,
                'kode_pegawai'   => $value->kd_pegawai,
                'nama_pegawai'   => $value->nama_pegawai,
                'gelar_depan'    => $value->gelar_depan,
                'gelar_belakang' => $value->gelar_belakang,
                'unit'           => $value->nama_sub_unit,
            ];
        }
        return $data;
    }

    public function mapperFirst($table)
    {
        $nama = $this->getNama($table);
        $foto = $this->getFoto($table->kd_pegawai, $table->foto);

        
        $unit = [
            'kode_unit' => $table->kd_sub_unit,
            'nama_unit' => $table->nama_sub_unit
        ];

        $data["akun"] = [
                'mac_address'   => $table->mac_address,
                'nama_device'   => $table->device,
                'kode_pegawai'  => $table->kd_pegawai,
                'nama_pegawai'  => $nama,
                'tempat_lahir'  => $table->tempat_lahir,
                'tanggal_lahir' => tanggal($table->tgl_lahir),
                'unit'          => $unit,
                'foto'          => $foto,
                'created_at'    => $table->created_at,
                'updated_at'    => $table->updated_at,
        ];

        return $data;
    }
}