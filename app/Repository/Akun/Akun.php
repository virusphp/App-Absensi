<?php

namespace App\Repository\Akun;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class Akun
{
    public function verif($params)
    {
        return DB::connection('sqlsrv_simrs')
        ->table('pegawai')
        ->select('kd_pegawai', 'nip','tgl_lahir',
                'nama_pegawai','gelar_depan','gelar_belakang')
        ->where([
            ['kd_pegawai', $params->kode_pegawai],
            ['tgl_lahir', $params->tanggal_lahir],
            ['kd_sub_unit', '!=', 0]
        ])
        ->first();
    }

    public function verifMac($mac)
    {
        return DB::table('akun')->select('mac_address')
            ->where('mac_address',$mac)
            ->first();
    }

    public function getProfil($username)
    {
        return DB::connection('sqlsrv_sms')
            ->table('akun as a')
            ->select('a.kd_pegawai','a.mac_address', 'device', 'a.status_update','a.created_at','a.updated_at',
                    'a.api_token','p.nama_pegawai','p.gelar_depan','p.gelar_belakang','su.kd_sub_unit',
                    'su.nama_sub_unit')
            ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','=', 'p.kd_pegawai')
            ->join('dbsimrs.dbo.sub_unit as su', 'p.kd_sub_unit','=', 'su.kd_sub_unit')
            ->where('a.kd_pegawai', $username)
            ->first();
    }

    public function simpan($params)
    {
        try {
            $akun =  DB::table('akun')->insert([
                'kd_pegawai'  => $params->kode_pegawai,
                'mac_address' => $params->mac_address,
                'device'      => $params->nama_device,
                'password'    => bcrypt($params->password),
                'api_token'   => generate_token($params->kode_pegawai, $params->password),
                'created_at'  => Carbon::now(),
            ]);

            if ($akun) {
                $akun = DB::connection('sqlsrv_sms')
                    ->table('akun as a')
                    ->select('a.kd_pegawai','a.mac_address', 'a.status_update','a.created_at','updated_at','a.api_token',
                            'p.nama_pegawai','p.gelar_depan','p.gelar_belakang','p.unit_kerja')
                    ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','=', 'p.kd_pegawai')
                    ->where('a.kd_pegawai', $params->kode_pegawai)
                    ->first();
                return $akun;
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}