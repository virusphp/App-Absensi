<?php

namespace App\Repository\Absen;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class Absen
{
    public function simpan($params)
    {
        try {
            $absen = $this->cekAbsenAwal($params);

            if ($absen)
            {
              return response()->jsonError(false, "Sudah Absen!!", "Sudah pernah absen ".absensi($params->status_absen)); 
            }

            $absen =  DB::table('absensi')->insert([
                'kd_pegawai'   => $params->kode_pegawai,
                'tanggal'      => $params->tanggal,
                'status_absen' => $params->status_absen,
                'kd_sub_unit'  => $params->kd_sub_unit,
            ]);

            if (!$absen) {
              return responst()->jsonError(false, "Error Transaction", "error proses insert data"); 
            }

             $absen = DB::table('absensi')
                    ->select('tanggal','status_absen')
                    ->where('kd_pegawai', $params->kode_pegawai)
                    ->first();

            return $absen;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cekAbsenAwal($params)
    {
        return DB::table('absensi')->where([
            ['tanggal', $params->tanggal],
            ['kd_pegawai', $params->kode_pegawai],
            ['status_absen', $params->status_absen]
        ])->first();
    }
}