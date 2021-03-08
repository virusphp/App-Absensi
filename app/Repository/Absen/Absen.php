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
                'tanggal'      => Carbon::now()->toDateString(),
                'jam'          => Carbon::now()->toTimeString(),
                'status_absen' => $params->status_absen,
                'kd_sub_unit'  => $params->kd_sub_unit,
                'generate_key' => $params->generate_key,
                'created_at '  => Carbon::now()
            ]);

            if ($absen) {
              $absen = DB::table('absensi')
                    ->select('tanggal', 'jam', 'status_absen')
                    ->where([
                        ['kd_pegawai', $params->kode_pegawai],
                        ['tanggal', Carbon::now()->toDateString()],
                    ])
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
            'a.tanggal', 'a.jam', 'a.status_absen', 'su.nama_sub_unit'
        )
            ->join('dbsimrs.dbo.sub_unit as su', 'a.kd_sub_unit','su.kd_sub_unit')
            ->whereMonth('a.tanggal', $params->bulan)
            ->whereYear('a.tanggal', $params->tahun)
            ->where('a.kd_pegawai', $params->kode_pegawai)
            ->orderBy('a.tanggal', 'desc')
            ->get();
    }

    public function getViewAbsenUnit($params)
    {
        return DB::table('absensi as a')->select(
            'a.id', 'p.nama_pegawai', 'a.tanggal', 'a.jam', 'a.status_absen', 'a.generate_key', 'su.nama_sub_unit'
        )
            ->join('dbsimrs.dbo.sub_unit as su', 'a.kd_sub_unit','su.kd_sub_unit')
            ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','p.kd_pegawai')
            ->where('a.tanggal', $params->tanggal)
            ->where(function($query) use ($params) {
                if ($params->kode_subunit != "") {
                    $query->where('a.kd_sub_unit', $params->kode_subunit);
                }
            })
            ->get();
    }

    public function cekAbsen($params)
    {
        $now = date('Y-m-d');
        // dd($now);
        return DB::table('absensi')
        ->whereDate('tanggal', $now)
        ->where([
            ['kd_pegawai', $params->kode_pegawai],
            ['status_absen', $params->status_absen]
        ])->first();
    }
}