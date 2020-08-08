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
            return response()->jsonError(false, "Ada Kesalahan", $message);
        }

        $data = ["kd_pegawai" => $r->kode_pegawai, "password" => $r->password];

        if (Auth::attempt($data)) {
            $akun =  $this->akun->getAkun($data["kd_pegawai"]);
            $transform = $this->transform->mapperFirst($akun);

            return response()->jsonSuccess(true, "Login Sukses!", $transform);
        }

        return response()->jsonError(false, "Terjadi Error Server", "Error code 500");
    }
}
