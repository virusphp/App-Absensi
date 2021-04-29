<?php

namespace App\Repository\Jadwal;

use DB;

class Jadwal
{
    public function getDaftarJadwal($params)
    {
        return DB::table('jadwal as j')
            ->select('j.kode_pegawai','p.nama_pegawai','jh.kode_shift','jh.status','jh.berlaku_mulai','ms.jam_masuk','ms.jam_keluar')
            ->join('jadwal_header as jh', 'j.kode_jadwal','jh.kode_jadwal')
            ->join('master_shift as ms', 'jh.kode_shift','ms.kode_shift')
            ->join('dbsimrs.dbo.pegawai as p', 'j.kode_pegawai','p.kd_pegawai')
            ->where([
                ['j.kode_pegawai', $params->kode_pegawai],
                ['jh.status', 1]
            ])
            ->orderBy('jh.berlaku_mulai', 'desc')
            ->first();
    }

    public function getDaftarJadwalUnit($params)
    {
        return DB::table('jadwal as j')
            ->select('j.kode_pegawai','p.nama_pegawai','jh.kode_shift','jh.status','jh.berlaku_mulai','ms.jam_masuk','ms.jam_keluar')
            ->join('jadwal_header as jh', 'j.kode_jadwal','jh.kode_jadwal')
            ->join('master_shift as ms', 'jh.kode_shift','ms.kode_shift')
            ->join('dbsimrs.dbo.pegawai as p', 'j.kode_pegawai','p.kd_pegawai')
            ->where([
                ['j.kode_sub_unit', $params->kode_subunit],
                ['jh.status', 1]
            ])
            ->orderBy('jh.berlaku_mulai', 'desc')
            ->get();
    }
}