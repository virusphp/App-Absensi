<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Validation\RegistrasiValidation;

class RegistrasiController extends ApiController
{
    public function register(Request $r, RegistrasiValidation $valid)
    {
        // dd($r->all());
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return $this->responseError($message, 422);
        }

        $akun = User::create($r->all());

        if ($akun) {
            return $this->responseSuccess($akun, 200);
        }

        return $this->ressponseError("Ops Terjadi kesalahan silhakn adi coba lagi!", 201);
      
    }
}
