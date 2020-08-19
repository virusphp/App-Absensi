<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Repository\Akun\Akun;
use App\Transform\TransformAkun;
use App\User;
use Illuminate\Http\Request;
use App\Validation\RegistrasiValidation;
use App\Validation\VerifValidation;

class RegistrasiController extends ApiController
{
    private $akun;
    private $transform;

    public function __construct()
    {
        $this->akun = new Akun;
        $this->transform = new TransformAkun();
    }

    public function register(Request $r, RegistrasiValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Error Require Form", $message);
        }

        // $verified = $this->akun->verif($r);
        // if (!$verified) {
        //     return response()->jsonError(false, "Ada Kesalahan Verifikasi data", ["Tempat lahir | Tanggal Lahir tidak sesuai","Silahkan menghubungi kepegawaian!"]);
        // }

        $akun = $this->akun->simpan($r);
        // dd($akun);

        if ($akun) {
            $transform = $this->transform->mapperFirst($akun);
            return response()->jsonSuccess(200, "Registrasi Sukses!", $transform);
        }

        return response()->jsonError(500, "Terjadi Error Server", "Internal sever error");
    }

    public function verified(Request $r, VerifValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Error Require Form", $message);
        }
        $verified = $this->akun->verif($r);
        // dd($verified);
        if (!$verified) {
            $verified = [
                "messageError" => "Sub Unit dan Tanggal Lahir tidak sesuai, Silahkan menghubungi kepegawaian!"
            ];
            return response()->jsonError(201, "Ada Kesalahan Verifikasi data", $verified);
        }

        $transform = $this->transform->mapperVerif($verified);
        // dd($transform);
        return response()->jsonSuccess(200, "Data Valid", $transform);
    }
}
