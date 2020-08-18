<?php

namespace App\Transform;

class TransformPegawai
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
        if ($table->gelar_depan == "-" && $table->gelar_belakang == "-") {
            $nama = $table->nama_pegawai;
        } else if($table->gelar_depan == "-") {
            $nama = $table->nama_pegawai. " ". $table->gelar_belakang;
        } else if($table->gelar_belakang == "-") {
            $nama = $table->gelar_depan. " ". $table->nama_pegawai;
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

        return $data;
    }
}