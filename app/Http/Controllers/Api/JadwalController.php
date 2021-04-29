<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DaftarJadwalCollection;
use App\Http\Resources\DaftarJadwalResource;
use App\Repository\Jadwal\Jadwal;
use App\Validation\DaftarJadwalValidation;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    protected $jadwal;

    public function __construct()
    {
        $this->jadwal = new Jadwal;
    }

    public function postDaftarJadwal(Request $r, DaftarJadwalValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, implode(",", $message), $message);
        }
        
        $jadwal = $this->jadwal->getDaftarJadwal($r);
        // dd($absen->count() === 0);

        if (!$jadwal) {
            $message = [
                "messageError" => "Belum ada jadwal terkait pada anda !!"
            ];
            return response()->jsonError(201, $message['messageError'], $message);
        }

        $transform = new DaftarJadwalResource($jadwal);

        return response()->jsonSuccess(200, "Daftar Jadwal", $transform);

    }

    public function postDaftarJadwalUnit(Request $r)
    {
        $jadwal = $this->jadwal->getDaftarJadwalUnit($r);

        if ($jadwal->count() === 0) {
            $message = [
                "messageError" => "Belum ada Jadwal Unit"
            ];
            return response()->jsonError(201, $message['messageError'], $message);
        }

        $transform = new DaftarJadwalCollection($jadwal);
        return response()->jsonSuccess(200, "Daftar Jadwal", $transform);
    }
}
