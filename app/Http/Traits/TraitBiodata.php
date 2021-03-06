<?php

namespace App\Http\Traits;

use Image;

trait TraitBiodata
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
        $wid = 472;
        $hig = 709;

        $dir = public_path(). DIRECTORY_SEPARATOR. "images" . DIRECTORY_SEPARATOR . "akun";
        file_put_contents($dir.DIRECTORY_SEPARATOR.($filename = $kodePegawai.".jpg"), $foto);

        $canvas = Image::canvas($wid, $hig);

        $image = Image::make($dir.DIRECTORY_SEPARATOR.$kodePegawai.".jpg")->resize($wid, $hig, function($constraint){
            $constraint->aspectRatio();
        });

        $canvas->insert($image, "center");

        $canvas->save($dir. \DIRECTORY_SEPARATOR. $kodePegawai. ".jpg");
       
        $fullPath = url("/") . DIRECTORY_SEPARATOR . "images". DIRECTORY_SEPARATOR. "akun" . DIRECTORY_SEPARATOR. $filename;
        
        return $fullPath;
    }
}