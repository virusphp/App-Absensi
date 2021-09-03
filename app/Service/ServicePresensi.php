<?php

namespace App\Service;

use App\Repository\Presensi\Presensi;
use App\Repository\Shift\Shift;

class ServicePresensi 
{
	protected $masterShift;
	protected $presensi;

	public function __construct()
	{
		$this->masterShift = new Shift;
		$this->presensi = new Presensi;
	}

	public function handlePresensi($kodeShift, $jamPresensi, $statuAbsen)
	{
		$jamShift = $this->masterShift->getShift($kodeShift);

		$jamShift = $statuAbsen == "1" ? $jamShift->jam_masuk : $jamShift->jam_keluar;

		$selisih = selisih($jamShift, $jamPresensi);

		$selisihMenit = selisihMenit($selisih);

		$presensi = $this->presensi->getPresensi($statuAbsen);

		$kodePresensi = '';
		foreach($presensi as $val) {
			if ($selisihMenit <= $val->menit) {
				$kodePresensi = $val->kode_presensi;
			} else {
				$kodePresensi = $val->kode_presensi;
			}

		}

		return $kodePresensi;	

	}
}