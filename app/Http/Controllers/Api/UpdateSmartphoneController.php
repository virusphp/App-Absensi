<?php

namespace App\Http\Controllers\Api;

use App\Validation\LoginValidation;
use App\Validation\UpdateValidation;
use Illuminate\Http\Request;
use Auth;
use App\Repository\Akun\Akun;
use App\Transform\TransformAkun;

class UpdateSmartphoneController extends ApiController
{
    private $akun;
    private $transform;

    public function __construct()
    {
        $this->akun = new Akun;
        $this->transform = new TransformAkun();
    }

    public function editSmartphone(Request $r, LoginValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Error Require Form", $message);
        }

        $data = ["kd_pegawai" => $r->username, "password" => $r->password];

        if (!Auth::guard("akun")->attempt($data)) {
            $message = [
                "messageError" => "Username atau password salah! tidak di izinkan"
            ];
            return response()->jsonError(403, "Terjadi Kesalahan!", $message);
        }

        $status =  $this->akun->getStatus($data["kd_pegawai"], 1);
       
        if (!$status) {
             $message = [
                "messageError" => "Status update anda blom di update di kepegawaian!!"
            ];
            return response()->jsonError(403, "Terjadi Kesalahan!", $message);
        }

        $akun = $this->akun->getProfil(($data['kd_pegawai']));

        $transform = $this->transform->mapperEditSmartphone($akun);

        return response()->jsonSuccess(200, "Login Sukses!", $transform);
    }

    public function updateSmartphone(Request $r, UpdateValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Error Require Form", $message);
        }

        $akun = $this->akun->update($r);

        if ($akun) {
            $transform = $this->transform->mapperFirst($akun);
            return response()->jsonSuccess(200, "Update Sukses!", $transform);
        }

        return response()->jsonError(500, "Terjadi Error Server", "Internal sever error");
    }
}
