<?php

namespace App\Repository\Pegawai;
use DB;

class Pegawai
{
    public function getPegawai()
    {
        return DB::connection('sqlsrv_simrs')->table('pegawai as p')->select(
            'p.kd_pegawai', 'p.nama_pegawai', 'p.alamat', 'p.nip', 'p.gelar_depan', 'p.gelar_belakang',
            'su.nama_sub_unit'
        )
        ->join('sub_unit as su', 'p.kd_sub_unit','=', 'su.kd_sub_unit')
        ->whereRaw('LEN(p.nip) > 5')
        ->get();
    }

    public function getPegawaiDetail($kodePegawai)
    {
        // dd($kodePegawai);
        return DB::connection('sqlsrv_sms')
            ->table('akun as a')
            ->select('a.kd_pegawai','a.mac_address', 'device', 'a.status_update','a.created_at','a.updated_at',
                    'a.api_token','p.nama_pegawai','p.gelar_depan','p.gelar_belakang','su.kd_sub_unit',
                    'su.nama_sub_unit')
            ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','=', 'p.kd_pegawai')
            ->join('dbsimrs.dbo.sub_unit as su', 'p.kd_sub_unit','=', 'su.kd_sub_unit')
            ->where('a.kd_pegawai', $kodePegawai)
            ->first();
    }
}