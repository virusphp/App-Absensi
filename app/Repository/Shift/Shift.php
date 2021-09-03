<?php

namespace App\Repository\Shift;

use DB;

class Shift 
{
	public function getShift($kodeShif)
	{
		return DB::table('master_shift')->select('jam_masuk','jam_keluar')
				->where('kode_shift', $kodeShif)->first();
	}
}