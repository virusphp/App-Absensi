<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Validation\LoginValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\Akun\Akun;
use App\Transform\TransformAkun;

class LoginController extends Controller
{
    private $akun;
    private $transform;

    public function __construct()
    {
        $this->akun = new Akun;
        $this->transform = new TransformAkun();
    }

    public function login(Request $r, LoginValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Ada Kesalahan", $message);
        }

        $verifMac = $this->akun->verifMac($r->mac_address);

        if(!$verifMac) {
            return response()->jsonError(403, "Terjadi Kesalahan!", "Smartphone yang di gunakan tidak sesuai dengan smartphon terdaftar!!");
        }

        $data = ["kd_pegawai" => $r->username, "password" => $r->password];

        if (!Auth::guard("akun")->attempt($data)) {
            return response()->jsonError(403, "Terjadi Kesalahan!", "Username atau password salah! tidak di izinkan");
        }
        
        $akun =  $this->akun->getProfil($data["kd_pegawai"]);
        // dd($akun);
        $transform = $this->transform->mapperLogin($akun);

        return response()->jsonSuccess(200, "Login Sukses!", $transform);
    }
}
