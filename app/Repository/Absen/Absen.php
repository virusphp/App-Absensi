<?php

namespace App\Repository\Absen;
use Carbon\Carbon;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class Absen
{
    public function simpan($params)
    {
        try {
            $absen =  DB::table('absensi')->insert([
                'kd_pegawai'   => $params->kode_pegawai,
                'tanggal'      => Carbon::now(),
                'status_absen' => $params->status_absen,
                'kd_sub_unit'  => $params->kd_sub_unit,
            ]);

            if ($absen) {
              $absen = DB::table('absensi')
                    ->select('tanggal','status_absen')
                    ->where('kd_pegawai', $params->kode_pegawai)
                    ->first();
                    
                return $absen;
            }
            
            throw Exception(["ok" => false, "message" => "Error inserting data", "result" => "none"]);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getDaftarAbsen($params)
    {
        return DB::table('absensi as a')->select(
            'a.tanggal', 'a.status_absen', 'su.nama_sub_unit'
        )
        ->join('dbsimrs.dbo.sub_unit as su', 'a.kd_sub_unit','su.kd_sub_unit')
        ->whereMonth('a.tanggal', $params->bulan)
        ->where('a.kd_pegawai', $params->kode_pegawai)
        ->get();
    }

    public function cekAbsen($params)
    {
        return DB::table('absensi')->where([
            ['tanggal', $params->tanggal],
            ['kd_pegawai', $params->kode_pegawai],
            ['status_absen', $params->status_absen]
        ])->first();
    }
}