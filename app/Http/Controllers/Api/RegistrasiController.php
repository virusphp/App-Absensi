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
            return response()->jsonError(false, "Ada Kesalahan", $message);
        }

        // $verified = $this->akun->verif($r);
        // if (!$verified) {
        //     return response()->jsonError(false, "Ada Kesalahan Verifikasi data", ["Tempat lahir | Tanggal Lahir tidak sesuai","Silahkan menghubungi kepegawaian!"]);
        // }

        $akun = $this->akun->simpan($r);

        if ($akun) {
            $transform = $this->transform->mapperFirst($akun);
            return response()->jsonSuccess(true, "Registrasi Sukses!", $transform);
        }

        return response()->jsonError(false, "Terjadi Error Server", "Error code 500");
    }

    public function verified(Request $r, VerifValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(false, "Ada Kesalahan", $message);
        }
        $verified = $this->akun->verif($r);
        // dd($verified);
        if (!$verified) {
            return response()->jsonError(false, "Ada Kesalahan Verifikasi data", ["Tempat lahir | Tanggal Lahir tidak sesuai","Silahkan menghubungi kepegawaian!"]);
        }

        $transform = $this->transform->mapperVerif($verified);
        // dd($transform);
        return response()->jsonSuccess(true, "Data Valid", $transform);
    }
}
