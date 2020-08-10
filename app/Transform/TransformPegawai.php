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
        $data["pegawai"] = [
                'nip'            => $table->nip,
                'kode_pegawai'   => $table->kd_pegawai,
                'nama_pegawai'   => $table->nama_pegawai,
                'tanggal_lahir'  => date("Y-m-d", strtotime($table->tgl_lahir)),
                'gelar_depan'    => $table->gelar_depan,
                'gelar_belakang' => $table->gelar_belakang,
                'unit'           => $table->nama_sub_unit,
        ];

        return $data;
    }
}