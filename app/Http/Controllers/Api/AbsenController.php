<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Absen\Absen;
use App\Transform\TransformAbsen;
use App\Validation\AbsenValidation;
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

    public function absen(Request $r, AbsenValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(false, "Ada Kesalahan", $message);
        }
        
        $absen = $this->absen->cekAbsen($r);

        if ($absen) {
            return response()->jsonError(false, "Sudah Absen!!", "Sudah pernah absen ".absensi($r->status_absen)); 
        }

        $absen = $this->absen->simpan($r);
        dd($absen);
        
        if (!$absen) {
            return response()->jsonError(false, "Terjadi Kesalhan", "Type data yang di insert tidak sesuai");
        }

        $transform = $this->transform->mapperFirst($absen);
        return response()->jsonSuccess(true, "Berhasil di simpan!", $transform);
    }
}
