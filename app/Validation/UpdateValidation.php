<?php

namespace App\Validation;
use Validator;

class UpdateValidation
{
    public function rules($request)
    {
        return Validator::make($request->all(), [
            'kode_pegawai' => 'required|min:5',
            'mac_address_lama' => 'required',
            'mac_address_baru' => 'required',
            'nama_device_lama' => 'required',
            'nama_device_baru' => 'required',
        ]);
    }

    public function messages($errors)
    {
        $error = [];
        foreach($errors->getMessages() as $key => $value)
        {
            $error[$key] = $value[0]; 
        }

        return $error;
    }
}