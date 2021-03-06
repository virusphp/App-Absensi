<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AkunResource;
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
            return response()->jsonError(422, implode(",",$message), ['messageError' => implode(",",$message)]);
        }

        $checkData = $this->akun->getDataAkun($r);
        // dd($checkData);
        if ($checkData) {
            return response()->jsonError(false, "Akun sudah terdaftar silahkan login !!", ['messageError' => "terdaftar pada device : ".$checkData->device]);
        }

        $akun = $this->akun->simpan($r);
        // dd($akun);

        if ($akun) {
            // $transform = $this->transform->mapperFirst($akun);
            $transform = new AkunResource($akun);

            return response()->jsonSuccess(200, "Registrasi Sukses!", $transform);
        }

        return response()->jsonError(500, "Terjadi Error Server", "Internal sever error");
    }

    public function verified(Request $r, VerifValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, implode(",",$message), $message);
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
