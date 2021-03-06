<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AkunResource;
use App\Http\Resources\PegawaiCollection;
use App\Http\Resources\PegawaiResource;
use Illuminate\Http\Request;
use App\Repository\Pegawai\Pegawai;
use App\Transform\TransformPegawai;

class PegawaiController extends Controller
{
    protected $pegawai;
    protected $transform;

    public function __construct()
    {
        $this->pegawai   = new Pegawai();
        $this->transform = new TransformPegawai;
    }

    public function getPegawai()
    {
        $data   = $this->pegawai->getPegawai();

        if(!$data) {
            return response()->jsonError(201, "Data tidak ditemukan!", $data);
        }
        
        $transform = new PegawaiCollection($data);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }

    public function getPegawaiDetail($kodaPegawai)
    {
        $data = $this->pegawai->getPegawaiDetail($kodaPegawai);

        if(!$data) {
            return response()->jsonError(201, "Data tidak ditemukan!", $data);
        }

        $transform = new AkunResource($data);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }
}
