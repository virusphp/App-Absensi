<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsenResource;
use App\Http\Resources\DaftaAbsenResource;
use App\Http\Resources\DaftarAbsenCollection;
use App\Http\Resources\DaftarAbsenUnitCollection;
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
            return response()->jsonError(422, implode(",", $message), $message);
        }
        
        $absen = $this->absen->getDaftarAbsen($r);
        // dd($absen->count() === 0);

        if ($absen->count() === 0) {
            $message = [
                "messageError" => "Belum ada absen pada bulan tersebut!!"
            ];
            return response()->jsonError(201, $message['messageError'], $message);
        }

        $transform = new DaftarAbsenCollection($absen);

        return response()->jsonSuccess(200, "Daftar Absen", $transform);

    }

    public function postAbsen(Request $r, AbsenValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, implode(",", $message), $message);
        }
        
        $absen = $this->absen->cekAbsen($r);

        if ($absen) {
            $message = [
                "messageError" => "Sudah pernah absen ".absensi($r->status_absen) . "Pukul : ".date('H:i:s', $r->jam)
            ];
            return response()->jsonError(403, $message['messageError'], $message); 
        }

        $absen = $this->absen->simpan($r);
        
        if (!$absen) {
            $message = [
                "messageError" => "Type data yang di insert tidak sesuai"
            ];
            return response()->jsonError(201, "Terjadi Kesalhan", $message);
        }

        $transform = new AbsenResource($absen);
        return response()->jsonSuccess(200, "Berhasil di simpan!", $transform);
    }

    public function reAbsen(Request $r, AbsenValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, implode(",", $message), $message);
        }

        $absen = $this->absen->simpan($r);
        
        if (!$absen) {
            $message = [
                "messageError" => "Type data yang di insert tidak sesuai"
            ];
            return response()->jsonError(201, "Terjadi Kesalhan", $message);
        }

        $transform = new AbsenResource($absen);
        return response()->jsonSuccess(200, "Berhasil di simpan!", $transform);
    }


    public function postDaftarAbsenUnit(Request $r)
    {
        $absen = $this->absen->getViewAbsenUnit($r);
        // dd($absen);

        if ($absen->count() === 0) {
            $message = [
                "messageError" => "Belum ada Unit yang absesn"
            ];
            return response()->jsonError(201, $message['messageError'], $message);
        }

        $transform = new DaftarAbsenUnitCollection($absen);
        return response()->jsonSuccess(200, "Daftar Absen", $transform);
    }
}
