<?php

namespace App\Validation;
use Validator;

class RegistrasiValidation
{
    public function rules($request)
    {
        return Validator::make($request->all(), [
            'kode_pegawai' => 'required|min:5|unique:akun,kd_pegawai',
            'mac_address' => 'required',
            'tanggal_lahir' => 'required',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password|min:6'
        ]);
    }

    public function messages($errors)
    {
        $error = [];
        foreach($errors->getMessages() as $key => $value)
        {
            // dd($value[0]);
            // $error = [];
            // foreach($errors->keys() as $val) {
                $error[$key] = $value[0]; 
            // }
        }
        // dd($error);
        return $error;
        // return [
        //     "kode_pegawai" => $errors->first('kode_pegawai'),
        //     "mac_address"  => $errors->first('mac_address'),
        //     "password"     => $errors->first('password'),
        //     "repassword"   => $errors->first('repassword')
        // ];
    }
}