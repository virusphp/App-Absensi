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
         return DB::connection('sqlsrv_simrs')->table('pegawai as p')->select(
            'p.kd_pegawai', 'p.nama_pegawai', 'p.alamat', 'p.nip', 'p.gelar_depan', 'p.gelar_belakang',
            'su.nama_sub_unit'
        )
        ->join('sub_unit as su', 'p.kd_sub_unit','=', 'su.kd_sub_unit')
        ->whereRaw("LEN(p.nip) > 5 and p.kd_pegawai='".$kodePegawai."'")
        // ->where([
        //     ['kd_pegawai', $kodePegawai],
        //     DB::whereRaw('LEN(p.nip) > 5')
        // ])
        ->first();

    }
}