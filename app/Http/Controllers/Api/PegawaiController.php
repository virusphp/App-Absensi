<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $pegawai   = $this->pegawai->getPegawai();
        $transform = $this->transform->all($pegawai);
        return response()->json($transform);
    }

    public function getPegawaiDetail($kodaPegawai)
    {
        $pegawai = $this->pegawai->getPegawaiDetail($kodaPegawai);
        $transform = $this->transform->detail($pegawai);
        return response()->json($transform);
    }
}
