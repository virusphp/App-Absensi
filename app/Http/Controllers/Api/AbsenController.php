<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Absen\Absen;
use App\Transform\TransformAbsen;
use App\Validation\AbsenValidation;
use App\Validation\DaftarAbsenValidation;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    protected $absen;
    protected $transform;

    public function __construct()
    {
        $this->absen = new Absen;
        $this->transform = new TransformAbsen;
    }

    public function postDaftarAbsen(Request $r, DaftarAbsenValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Error Require Form", $message);
        }
        
        $absen = $this->absen->getDaftarAbsen($r);
        // dd($absen);

        if (!$absen) {
            $message = [
                "messageError" => "Smartphone yang di gunakan tidak sesuai dengan smartphon terdaftar!!"
            ];
            return response()->jsonError(201, "Terjadi Kesalhan", $message);
        }

        $transform = $this->transform->mapperDaftar($absen);
        return response()->jsonSuccess(200, "Daftar Absen", $transform);

    }

    public function postAbsen(Request $r, AbsenValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Error Require Form", $message);
        }
        
        $absen = $this->absen->cekAbsen($r);
        // dd($absen);

        if ($absen) {
            $message = [
                "messageError" => "Sudah pernah absen ".absensi($r->status_absen)
            ];
            return response()->jsonError(403, "Sudah Absen!!", $message); 
        }

        $absen = $this->absen->simpan($r);
        
        if (!$absen) {
            $message = [
                "messageError" => "Type data yang di insert tidak sesuai"
            ];
            return response()->jsonError(201, "Terjadi Kesalhan", $message);
        }

        $transform = $this->transform->mapperFirst($absen);
        return response()->jsonSuccess(200, "Berhasil di simpan!", $transform);
    }
}
