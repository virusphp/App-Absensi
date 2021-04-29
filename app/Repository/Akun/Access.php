<?php

namespace App\Repository\Akun;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class Access
{
    public function getProfil($username)
    {
        return DB::connection('sqlsrv_sms')
            ->table('access')
            ->select('nama','email','username','phone','api_token','created_at','updated_at')
            ->where('username', $username)
            ->first();
    }

    public function simpan($params)
    {
        try {
            $akun =  DB::table('access')->insert([
                'nama' => $params->nama,
                'username' => $params->username,
                'email' => $params->email,
                'password' => bcrypt($params->password),
                'phone' => $params->phone,
                'api_token' => generate_token($params->username, $params->password),
                'created_at' => Carbon::now(),
            ]);

            if (!$akun) {
              return responst()->jsonError(false, "Error Transaction", "error proses insert data"); 
            }

             $akun = DB::table('access')
                    ->select('nama','username','phone','email','api_token','created_at','updated_at')
                    ->where('username', $params->username)
                    ->first();

            return $akun;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}