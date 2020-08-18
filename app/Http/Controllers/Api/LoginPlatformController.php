<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Akun\Access;
use App\Transform\TransformAccess;
use App\Validation\LoginValidation;
use Illuminate\Http\Request;
use Auth;

class LoginPlatformController extends Controller
{
    public function __construct()
    {
        $this->access = new Access;
        $this->transform = new TransformAccess;
    }

    public function login(Request $r, LoginValidation $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422, "Ada Kesalahan", $message);
        }

        $data = ["username" => $r->username, "password" => $r->password];

        if (!Auth::guard("access")->attempt($data)) {
            return response()->jsonError(403, "Terjadi Kesalahan!", "Username atau password salah! tidak di izinkan");
        }

        $akun =  $this->access->getProfil($data["username"]);
        $transform = $this->transform->mapperFirst($akun);

        return response()->jsonSuccess(200, "Login Sukses!", $transform);

    }
}
