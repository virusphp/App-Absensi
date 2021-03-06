<?php

namespace App\Validation;
use Validator;

class AssesmentValidation
{
    public function rules($request)
    {
        return Validator::make($request->all(), [
            'kode_pegawai' => 'required|numeric|min:8',
            'kode_assesment' => 'required',
            'score' => 'required',
        ],[
            'required' => 'Tidak boleh kosong!!',
            'min' => 'Minimal harus 8 digit!!', 
            'numeric' => 'Parameter harus number!!'
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