<?php

namespace App\Repository\Presensi;

use DB;

class Presensi 
{
	public function getPresensi($statusAbsen, $terlambat)
	{
		return DB::table('absensi_presensi')->select('kode_presensi', 'start', 'menit')
				->where([
					['status_absen', $statusAbsen],
					['start', '>=', $terlambat],
					['menit', '<=', $terlambat]
				])
				->first();
	}

	public function getLembur($statusAbsen)
	{
		return DB::table('absensi_presensi')->select('kode_presensi', 'start', 'menit as end')
				->where('status_absen', $statusAbsen)
				->first();
	}

}