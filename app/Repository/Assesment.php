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

	public function simpanAssesement($params, $date)
	{
		$cekWarna =  DB::connection('sqlsrv_sms')
                        ->table('self_assesment_warna')
                        ->where('kode_assesment',$params->kode_assesment)
                        ->get();

        foreach($cekWarna as $w)
        {
            if ($params->score >= $w->batas_bawah && $params->score <= $w->batas_atas) {
                $warna = $w->id;
            }
        }

		return DB::connection('sqlsrv_sms')
			->table('self_assesment_hasil')
			->insert([
				'kode_pegawai'      => $params->kode_pegawai,
				'kode_assesment'    => $params->kode_assesment,
				'tanggal_assesment' => $date,
				'score' 			=> $params->score,
				'assesment_warna_id'=> $warna
			]);

	}

	public function getDataAssesment($params, $date)
	{
		return DB::connection('sqlsrv_sms')
			->table('self_assesment_hasil as h')
			->select('h.kode_pegawai','m.nama_assesment','h.tanggal_assesment','h.score','w.symbol_warna','w.keterangan')
			->join('self_assesment_header as m', 'h.kode_assesment','m.kode_assesment')
			->join('self_assesment_warna as w', 'h.assesment_warna_id','w.id')
			->where([
				['h.kode_pegawai', $params->kode_pegawai],
				['h.tanggal_assesment', $date]
			])
			->first();
	}

	public function getHasilAssesment($params)
	{
		return DB::connection('sqlsrv_sms')
			->table('self_assesment_hasil as h')
			->select('h.kode_pegawai','m.nama_assesment','h.tanggal_assesment','h.score','w.symbol_warna','w.keterangan')
			->join('self_assesment_header as m', 'h.kode_assesment','m.kode_assesment')
			->join('self_assesment_warna as w', 'h.assesment_warna_id','w.id')
			->where('kode_pegawai', $params->kode_pegawai)
			->get();
	}
}