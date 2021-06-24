<?php

namespace App\Repository;

use DB;

class Assesment
{
	public function getAssesment()
	{
		return DB::connection('sqlsrv_sms')
			->table('self_assesment_header')
			->select('kode_assesment','nama_assesment')
			->where('status', 1)
			->get();
	}

	public function getAssesmentDetail($params)
	{
		return DB::connection('sqlsrv_sms')
			->table('self_assesment_detail')
			->select('kode_question','question','skor_yes','skor_no','sort')
			->where('kode_assesment', $params->kode_assesment)
			->orderBy('sort', 'asc')
			->get();
	}

	public function simpanAssesement($params)
	{
		return DB::connection('sqlsrv_sms')
			->table('self_assesment_hasil')
			->insert([
				'kode_pegawai'      => $params->kode_pegawai,
				'kode_assesment'    => $params->kode_assesment,
				'tanggal_assesment' => date("Y-m-n H:i:s")
			]);
	}
}