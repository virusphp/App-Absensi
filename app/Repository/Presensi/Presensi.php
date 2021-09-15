<?php

namespace App\Repository\Presensi;

use DB;

class Presensi 
{
	public function getPresensi($statusAbsen, $terlambat)
	{
		return DB::table('absensi_presensi')->select('kode_presensi', 'menit')
				->where([
					['status_absen', $statusAbsen],
					['menit', '>=', $terlambat]
				])->first();
	}

}