<?php

namespace App\Repository\Jadwal;

use DB;

class Jadwal
{
    public function getDaftarShift($params)
    {
        return DB::table('jadwal_shift_detail as j')
            ->select('j.kode_shift')
            ->where([
                ['j.kode_pegawai', $params->kode_pegawai],
                ['j.tanggal', date('Y-m-d')]
            ])
            ->first();
    }

    public function getDaftarNonShift($params) 
    {
        return DB::table('jadwal_non_shift as j')
            ->select('jd.kode_shift')
            ->join('jadwal_header as jh', 'j.kode_jadwal','jh.kode_jadwal')
            ->join('jadwal_detail as jd', 'j.kode_jadwal', 'jd.kode_jadwal')
            ->where([
                ['jh.status', 1],
                ['jd.day_order', tanggalNilai(date("Y-m-d"))],
                ['j.kode_pegawai', $params->kode_pegawai]
            ])
            ->orderBy('j.created_at', 'desc')
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
    
    public function getDaftarJadwal($params)
    {   

        return DB::table('jadwal_shift_detail as jd')
            ->select('jd.tanggal','ms.kode_shift','ms.nama_shift','ms.jam_masuk','ms.jam_keluar')
            ->leftJoin('master_shift as ms', 'jd.kode_shift', '=', 'ms.kode_shift')
            ->where('jd.kode_pegawai',$params->kode_pegawai)
            ->whereYear('jd.tanggal', $params->tahun)
            ->whereMonth('jd.tanggal', $params->bulan)
            // ->where([
            //     ['jd.kode_pegawai', $params->kode_pegawai],
            //     ['jd.tanggal', $params->bulan],
            //     ['jd.tanggal', $params->tahun]
            // ]
            // )
            ->get();
    }

    public function getJadwalNonShif($params)
    {
        return DB::table('jadwal_non_shift as jns')
            ->select('jd.day_order','ms.kode_shift','ms.nama_shift','ms.jam_masuk','ms.jam_keluar')
            ->join('jadwal_detail as jd', 'jns.kode_jadwal','jd.kode_jadwal')
            ->leftJoin('master_shift as ms', 'jd.kode_shift','ms.kode_shift')
            ->where('jns.kode_pegawai', $params->kode_pegawai)
            ->get();
    }
}