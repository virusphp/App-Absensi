<?php

namespace App\Http\Traits;

use Image;
use File;

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
        // $width = config('photo.image.small.width');
        // $height = config('photo.image.small.height');
        
        // $filename = $kodePegawai. ".jpg";
        // $destination = config('photo.profil.directory');

        // $storageDir = storage_path("app/public".DIRECTORY_SEPARATOR. $destination);

        // if (!is_dir($storageDir)) {
        //     File::makeDirectory($storageDir, 0777, true, true);
        // }
        // file_put_contents($storageDir.DIRECTORY_SEPARATOR.$filename, $foto);

        // if (mime_content_type($storageDir.DIRECTORY_SEPARATOR.$kodePegawai.".jpg") == "image/jpeg") {
        //     $canvas = Image::canvas($width, $height);

        //     $image = Image::make($storageDir .DIRECTORY_SEPARATOR. $kodePegawai.".jpg")->resize($width, $height, function($constraint){
        //         $constraint->aspectRatio();
        //     });

        //     $canvas->insert($image, "center");

        //     $canvas->save($storageDir .DIRECTORY_SEPARATOR. $kodePegawai. ".jpg");

        //     // $fullPath =  $destination . DIRECTORY_SEPARATOR. $filename;
        //     $fullPath =  url("/") .DIRECTORY_SEPARATOR. "storage". $destination . DIRECTORY_SEPARATOR . $filename;
        // } else {
        //     $fullPath =  url('/') .DIRECTORY_SEPARATOR. "storage". $destination . DIRECTORY_SEPARATOR. $filename;
            
        //     return $fullPath;
        // }
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