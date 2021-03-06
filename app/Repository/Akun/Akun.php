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
        ->table('pegawai as p')
        ->select('p.kd_pegawai', 'p.nip','p.tgl_lahir',
                'p.nama_pegawai','p.gelar_depan', 'p.gelar_belakang', 'su.nama_sub_unit')
        ->where([
            ['p.kd_pegawai', $params->kode_pegawai],
            ['p.tgl_lahir', $params->tanggal_lahir],
            ['su.kd_sub_unit', '!=', 0]
        ])
        ->join('sub_unit as su', 'p.kd_sub_unit','=', 'su.kd_sub_unit')
        ->first();
    }

    public function verifMac($params)
    {
        return DB::table('akun')->select('mac_address', 'status_update')
            ->where([
                ['mac_address',$params->mac_address],
                ['kd_pegawai',$params->username],
                ['status_update', 0]
            ])
            ->first();
    }

    public function getStatus($username, $status)
    {
        return DB::connection('sqlsrv_sms')
        ->table('akun as a')
        ->select('a.status_update')
        ->where([
            ['a.kd_pegawai', $username],
            ['a.status_update', $status],
        ])
        ->first();
    }

    public function getPhone($params)
    {
        return DB::table('akun')->select('device')
            ->where([
                ['kd_pegawai',$params->username],
            ])
            ->first();
    }

    public function getProfil($username)
    {
        return DB::connection('sqlsrv_sms')
            ->table('akun as a')
            ->select('a.kd_pegawai','a.mac_address', 'device', 'a.status_update','a.created_at','a.updated_at',
                    'a.api_token','p.nama_pegawai','p.gelar_depan','p.gelar_belakang', 'p.tempat_lahir','tgl_lahir','su.kd_sub_unit',
                    'su.nama_sub_unit', 'foto', 'status_update')
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
                    ->select('a.kd_pegawai','a.mac_address','device','a.status_update','a.created_at','updated_at','a.api_token',
                            'p.nama_pegawai','p.gelar_depan','p.gelar_belakang','p.foto','su.kd_sub_unit','su.nama_sub_unit')
                    ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','=', 'p.kd_pegawai')
                    ->join('dbsimrs.dbo.sub_unit as su', 'p.kd_sub_unit','=', 'su.kd_sub_unit')
                    ->where('a.kd_pegawai', $params->kode_pegawai)
                    ->first();
                return $akun;
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($params)
    {
        try {
            $akun =  DB::table('akun')
            ->where([
                ['kd_pegawai', $params->kode_pegawai],
                ['mac_address', $params->mac_address_lama],
            ])
            ->update([
                'mac_address'   => $params->mac_address_baru,
                'device'        => $params->nama_device_baru,
                'status_update' => "0",
            ]);

            if ($akun) {
                $akun = DB::connection('sqlsrv_sms')
                    ->table('akun as a')
                    ->select('a.kd_pegawai','a.mac_address','device','a.status_update','a.created_at','updated_at','a.api_token',
                            'p.nama_pegawai','p.gelar_depan','p.gelar_belakang','su.kd_sub_unit','su.nama_sub_unit')
                    ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','=', 'p.kd_pegawai')
                    ->join('dbsimrs.dbo.sub_unit as su', 'p.kd_sub_unit','=', 'su.kd_sub_unit')
                    ->where('a.kd_pegawai', $params->kode_pegawai)
                    ->first();
                return $akun;
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}