<?php

namespace App\Validation;
use Validator;

class AbsenValidation
{
    public function rules($request)
    {
        return Validator::make($request->all(), [
            'kode_pegawai' => 'required',
            'tanggal' => 'required',
            'status_absen' => 'required|max:1',
            'kd_sub_unit' => 'required',
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