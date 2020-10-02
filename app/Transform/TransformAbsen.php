<?php

namespace App\Transform;

class TransformAbsen
{
    public function mapperFirst($table)
    {
        $data["absen"] = [
                'tanggal'      => tanggal($table->tanggal),
                'jam'          => waktu($table->jam),
                'status_absen' => $table->status_absen,
        ];
        return $data;
    }

    public function mapperDaftar($table)
    {
        foreach ($table as $value) {
            $data["list_absen"][] = [
                'tanggal'   => tanggal($value->tanggal),
                'jam'   => waktu($value->jam),
                'status_absen'    => absensi($value->status_absen),
                'nama_unit' => $value->nama_sub_unit,
            ];
        }
        return $data;
    }

}