<?php

namespace App\Repository\Pegawai;
use DB;

class Pegawai
{
    public function getPegawai()
    {
        return DB::connection('sqlsrv_simrs')->table('pegawai as p')->select(
            'p.kd_pegawai', 'p.nama_pegawai', 'p.alamat', 'p.nip', 'p.gelar_depan', 'p.gelar_belakang',
            's.nama_sub_unit'
        )
        ->whereRaw('LENGTH(p.nip) > 5')
        ->get();
    }

    public function getPegawaiDetail($kodePegawai)
    {
        
    }
}