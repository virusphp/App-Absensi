<?php

namespace App\Transform;

class TransformAccess
{
    public function mapperLogin($table)
    {
        $data["access"] = [
                'nama'   => $table->nama,
                'username'   => $table->username,
                'email'   => $table->email,
                'phone'   => $table->phone,
                'created_at'     => $table->created_at,
                'updated_at'     => $table->updated_at,
        ];

        $data["api_token"] = $table->api_token;

        return $data;
    }

    public function mapperFirst($table)
    {
        $data["access"] = [
                'nama'       => $table->nama,
                'email'      => $table->email,
                'username'   => $table->username,
                'created_at' => $table->created_at,
                'updated_at' => $table->updated_at,
        ];

        $data["api_token"] = $table->api_token;

        return $data;
    }

}