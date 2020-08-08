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
        $data["akun"] = [
                'mac_address'    => $table->mac_address,
                'kode_pegawai'   => $table->kd_pegawai,
                'nama_pegawai'   => $table->nama_pegawai,
                'gelar_depan'    => $table->gelar_depan,
                'gelar_belakang' => $table->gelar_belakang,
                'unit'           => $table->unit_kerja,
                'created_at'     => $table->created_at,
                'updated_at'     => $table->updated_at,
        ];

        $data["api_token"] = $table->api_token;

        return $data;
    }

}