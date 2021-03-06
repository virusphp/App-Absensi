<?php

namespace App\Validation;
use Validator;

class HasilAssesmentValidation
{
    public function rules($request)
    {
        return Validator::make($request->all(), [
            'kode_pegawai' => 'required',
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