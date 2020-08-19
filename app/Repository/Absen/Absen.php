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
                'tanggal'      => $params->tanggal,
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

    public function cekAbsen($params)
    {
        return DB::table('absensi')->where([
            ['tanggal', $params->tanggal],
            ['kd_pegawai', $params->kode_pegawai],
            ['status_absen', $params->status_absen]
        ])->first();
    }
}