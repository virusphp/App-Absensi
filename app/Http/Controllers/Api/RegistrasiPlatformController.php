<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Akun\Access;
use App\Validation\RegistrasiPlatform;
use App\Transform\TransformAccess;

class RegistrasiPlatformController extends Controller
{
    protected $access;
    protected $transform;

    public function __construct()
    {
        $this->access = new Access;
        $this->transform = new TransformAccess;
    }
    public function register(Request $r, RegistrasiPlatForm $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(false, "Ada Kesalahan", $message);
        }

        $akun = $this->access->simpan($r);

        if ($akun) {
            $transform = $this->transform->mapperFirst($akun);
            return response()->jsonSuccess(true, "Registrasi Sukses!", $transform);
        }

        return response()->jsonError(false, "Terjadi Error Server", "Error code 500");
    }
}
