<?php

namespace App\Transform;

class TransformPegawai extends ResponseTransform
{
    public function all($params)
    {
        if(!$params) {
            $data = $this->responseError("Data Tidak Tersedia!");
            return response()->json($data)->getData();
        }
        $data = $this->responseTransform($this->mapperAll($params));
        return response()->json($data)->getData();
    }

    public function detail($params)
    {
        if (!$params) {
            $data = $this->responseError("Data Tidak ditemukan!");
            return response()->json($data)->getData();
        }
        $data = $this->responseTransform($this->mapperFirst($params));
        return response()->json($data)->getData();

    }

    private function mapperAll($table)
    {
        foreach ($table as $value) {
            $data["pegawai"][] = [
                'nip'            => $value->nip,
                'kode_pegawai'   => $value->kd_pegawai,
                'nama_pegawai'   => $value->nama_pegawai,
                'gelar_depan'    => $value->gelar_depan,
                'gelar_belakang' => $value->gelar_belakang,
                'unit'           => $value->nama_sub_unit,
            ];
        }
        return $data;
    }

    private function mapperFirst($table)
    {
        $data["pegawai"] = [
                'nip'            => $table->nip,
                'kode_pegawai'   => $table->kd_pegawai,
                'nama_pegawai'   => $table->nama_pegawai,
                'gelar_depan'    => $table->gelar_depan,
                'gelar_belakang' => $table->gelar_belakang,
                'unit'           => $table->nama_sub_unit,
        ];

        return $data;
    }
}