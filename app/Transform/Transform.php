<?php

namespace App\Transform;

class Transform
{
    public function getNama($table)
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
        return $nama;
    }

    protected function getFoto($kodePegawai, $foto)
    {
        $dir = public_path(). DIRECTORY_SEPARATOR. "images" . DIRECTORY_SEPARATOR . "akun";
        file_put_contents($dir.DIRECTORY_SEPARATOR.($filename = $kodePegawai.".jpg"), $foto);
        $fullPath = $dir . DIRECTORY_SEPARATOR . $filename;
        return $fullPath;
    }
}