<?php

namespace App\Transform;

class TransformAkun
{
    public function mapperLogin($table)
    {
        $data["akun"] = [
                'kode_pegawai'   => $table->kd_pegawai,
                'created_at'     => $table->created_at,
                'updated_at'     => $table->updated_at,
        ];

        $data["api_token"] = $table->api_token;

        return $data;
    }

    public function mapperFirst($table)
    {
        if ($table->gelar_depan == "-" && $table->gelar_belakang == "-") {
            $nama = $table->nama_pegawai;
        } else if($table->gelar_depan == "-") {
            $nama = $table->nama_pegawai. ",". $table->gelar_belakang;
        } else if($table->gelar_belakang == "-") {
            $nama = $table->gelar_depan. ".". $table->nama_pegawai;
        } else {
            $nama = $table->gelar_depan. ".". $table->nama_pegawai. "," . $table->gelar_belakang;
        }

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