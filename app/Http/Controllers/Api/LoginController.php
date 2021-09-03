<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AkunResource;
use App\Validation\LoginValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\Akun\Akun;
use App\Repository\Version\Version;
use App\Transform\TransformAkun;

class LoginController extends Controller
{
    private $akun;
    private $version;
    private $transform;

    public function __construct()
    {
        $this->akun = new Akun;
        $this->version = new Version;
        $this->transform = new TransformAkun();
    }

    public function login(Request $r, LoginValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422,  implode(",",$message), $message);
        }

        $verifMac = $this->akun->verifMac($r);
        // dd($verifMac);
        
        if(!$verifMac) {
            $getPhone = $this->akun->getPhone($r);
            if ($getPhone) {

                $message = [
                    "messageError" => "Smartphone tidak sesuai dengan smartphon terdaftar!! ($getPhone->device)"
                ];
            } else {
                $message = [
                        "messageError" => "Smartphone belum terdaftar pada aplikasi presensi!!! Silahkan Mendaftar!!"
                ];
            }

            return response()->jsonError(401, $message['messageError'],  $message);
        }

        $checkVersion = $this->version->getVersion($r);
        // dd($checkVersion);
        if (!$checkVersion) {
            $message = [
                "messageError" => "Versi applikasi sudah usang silahkan perbarui aplikasi ( Update Aplikasi )!"
            ];

            return response()->jsonError(202, $message['messageError'], $message);
        }


        $data = ["kd_pegawai" => $r->username, "password" => $r->password];

        if (!Auth::guard("akun")->attempt($data)) {
            $message = [
                "messageError" => "Username atau password salah! tidak di izinkan"
            ];
            return response()->jsonError(403, $message['messageError'], $message);
        }
        
        $akun =  $this->akun->getProfil($data["kd_pegawai"]);

        $transform = new AkunResource($akun);

        return response()->jsonSuccess(200, "Login Sukses!", $transform);
    }
}
