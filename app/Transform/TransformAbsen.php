<?php

namespace App\Transform;

class TransformAbsen
{
    public function mapperFirst($table)
    {
        $data["absen"] = [
                'tanggal'      => $table->tanggal,
                'status_absen' => $table->status_absen,
        ];
        return $data;
    }

    public function mapperDaftar($table)
    {
        foreach ($table as $value) {
            $data["absen"][] = [
                'tanggal'   => tanggal($value->tanggal),
                'jam'   => waktu($value->tanggal),
                'status_absen'    => absensi($value->status_absen),
                'nama_unit' => $value->nama_sub_unit,
            ];
        }
        return $data;
    }

}