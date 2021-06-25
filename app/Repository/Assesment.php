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
				'tanggal_assesment' => date("Y-m-d H:i:s"),
				'score' 			=> $params->score
			]);
	}

	public function getHasilAssesment($params)
	{
		return DB::connection('sqlsrv_sms')
			->table('self_assesment_hasil as h')
			->select('h.kode_pegawai','m.nama_assesment','h.tanggal_assesment','h.score')
			->join('self_assesment_header as m', 'h.kode_assesment','m.kode_assesment')
			->where('kode_pegawai', $params->kode_pegawai)
			->get();
	}
}