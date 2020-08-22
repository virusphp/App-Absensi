<?php

namespace App\Transform;

class TransformAkun extends Transform
{

    public function mapperFirst($table)
    {
        $nama = $this->getNama($table);

        $unit = [
            'kode_unit' => $table->kd_sub_unit,
            'nama_unit' => $table->nama_sub_unit
        ];

        $data["akun"] = [
                'mac_address'  => $table->mac_address,
                'nama_device'  => $table->device,
                'kode_pegawai' => $table->kd_pegawai,
                'nama_pegawai' => $nama,
                'unit'         => $unit,
                'created_at'   => $table->created_at,
                'updated_at'   => $table->updated_at,
        ];

        $data["api_token"] = $table->api_token;

        return $data;
    }

    public function mapperLogin($table)
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

        $data["api_token"] = $table->api_token;

        return $data;
    }

    public function mapperVerif($table)
    {
        $data["pegawai"] = [
            'nip'             => $table->nip,
            'kode_pegawai'    => $table->kd_pegawai,
            'nama_pegawai'    => $table->nama_pegawai,
            'tanggal_lahir'   => $table->tgl_lahir,
            'gelar_depan'     => $table->gelar_depan,
            'gelar_belakang'  => $table->gelar_belakang,
        ];
        return $data;
    }

}