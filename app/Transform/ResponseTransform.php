<?php

namespace App\Transform;

class ResponseTransform
{
    protected function responseTransform($data = [])
    {
        return [
            "ok"     => true,
            "code"   => 200,
            "result" => $data
        ];
    }

    protected function responseError($errorMessage)
    {
        return [
            "ok"     => false,
            "code"   => 201,
            "message" => $errorMessage
        ];
    }
}