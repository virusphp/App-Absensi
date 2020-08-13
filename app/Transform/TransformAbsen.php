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

}