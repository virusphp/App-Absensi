<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Pegawai;

class PegawaiController extends Controller
{
    protected $pegawai;

    public function __construct()
    {
        $this->pegawai = new Pegawai();
    }

    public function getPegawai()
    {
        $pegawai = $this->pegawai->getPegawai();
        $transform = $this->transformPegawai->all($pegawai);
        return response()->json($transform);
    }

    public function getPegawaiDetail()
    {

    }
}
