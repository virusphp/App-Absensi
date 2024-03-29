<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AbsenResource;
use App\Http\Resources\DaftaAbsenResource;
use App\Http\Resources\DaftarAbsenCollection;
use App\Http\Resources\DaftarAbsenUnitCollection;
use App\Repository\Absen\Absen;
use App\Repository\Jadwal\Jadwal;
use App\Transform\TransformAbsen;
use App\Validation\AbsenValidation;
use App\Validation\DaftarAbsenValidation;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    protected $absen;
    protected $transform;
    protected $jadwal;

    public function __construct()
    {
        $this->absen = new Absen;
        $this->jadwal = new Jadwal;
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
        // dd($absen);

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
                "messageError" => "Sudah pernah absen ".absensi($r->status_absen) . " Pukul : ". waktu($absen->jam)
            ];
            return response()->jsonError(403, $message['messageError'], $message); 
        }

        $jadwal =  $this->jadwal->getDaftarShift($r);

        if (isset($jadwal)) {
            if ($jadwal->kode_shift == NULL) {
                $message = [
                    "messageError" => "Jadwal Belum di input hubungi kepegawaian!!"
                ];
                return response()->jsonError(201, $message['messageError'], $message);
            }
        }

        if (!$jadwal) {
            $jadwal = $this->jadwal->getDaftarNonShift($r);
            if(!$jadwal) {
                $message = [
                    "messageError" => "Jadwal Belum di input hubungi kepegawaian!!"
                ];
                return response()->jsonError(201, $message['messageError'], $message);
            }
        } 

        $absen = $this->absen->simpan($r, $jadwal);
        
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

        $jadwal =  $this->jadwal->getDaftarShift($r);
        if (!$jadwal) {
            $jadwal = $this->jadwal->getDaftarNonShift($r);
            if(!$jadwal) {
                $message = [
                    "messageError" => "Jadwal Belum di input hubungi kepegawaian!!"
                ];
                return response()->jsonError(201, $message['messageError'], $message);
            }
        } 

        $absen = $this->absen->simpan($r, $jadwal);
        
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
