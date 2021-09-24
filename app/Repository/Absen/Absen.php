<?php

namespace App\Repository\Absen;

use App\Repository\Jadwal\Jadwal;
use App\Service\ServicePresensi;
use Carbon\Carbon;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class Absen
{
    protected $jadwal;
    protected $servicePresensi;

    public function __construct()
    {
        $this->jadwal = new Jadwal;
        $this->servicePresensi = new ServicePresensi;
    }

    public function simpan($params, $jadwal)
    {
        $presensi = $this->servicePresensi->handlePresensi($jadwal->kode_shift, Carbon::now()->toTimeString(), $params->status_absen);

        try {
            $absen =  DB::table('absensi')->insert([
                'kd_pegawai'   => $params->kode_pegawai,
                'tanggal'      => Carbon::now()->toDateString(),
                'jam'          => Carbon::now()->toTimeString(),
                'status_absen' => $params->status_absen,
                'kd_sub_unit'  => $params->kd_sub_unit,
                'kode_shift'   => $jadwal->kode_shift,
                'kode_presensi'=> $presensi,
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
           'a.tanggal', 'a.jam', 'a.status_absen', 'su.nama_sub_unit', 'a.generate_key', 'ms.jam_masuk','ms.jam_keluar', 'a.kode_shift', 'kd_jns_pegawai'
        )
            ->join('dbsimrs.dbo.sub_unit as su', 'a.kd_sub_unit','su.kd_sub_unit')
            ->leftJoin('master_shift as ms','a.kode_shift','ms.kode_shift')
            ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','p.kd_pegawai')
            ->whereMonth('a.tanggal', $params->bulan)
            ->whereYear('a.tanggal', $params->tahun)
            ->where('a.kd_pegawai', $params->kode_pegawai)
            ->orderBy('a.tanggal', 'desc')
            ->get();
    }

    public function getViewAbsenUnit($params)
    {
        return DB::table('absensi as a')->select(
            'a.id', 'a.tanggal', 'a.jam', 'a.status_absen', 'su.nama_sub_unit', 'a.generate_key', 'p.kd_pegawai', 'p.nama_pegawai','ms.jam_masuk','ms.jam_keluar', 'a.kode_shift'
        )
            ->join('dbsimrs.dbo.sub_unit as su', 'a.kd_sub_unit','su.kd_sub_unit')
            ->join('dbsimrs.dbo.pegawai as p', 'a.kd_pegawai','p.kd_pegawai')
            ->leftJoin('master_shift as ms','a.kode_shift','ms.kode_shift')
            ->where('a.tanggal', $params->tanggal)
            ->where(function($query) use ($params) {
                if ($params->kode_subunit != "") {
                    $query->where('a.kd_sub_unit', $params->kode_subunit);
                }
            })
            ->orderBy('a.jam', 'asc')
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