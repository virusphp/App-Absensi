<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Absen\Absen;
use App\Transform\TransformAbsen;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    protected $absen;
    protected $transform;

    public function __construct()
    {
        $this->absen = new Absen;
        $this->transform = new TransformAbsen;
    }

    public function absen(Request $r)
    {
        $absen = $this->absen->simpan($r);
        
        if (!$absen) {
             return response()->jsonError(false, "Terjadi Error Server", "Error code 500");
        }

        $transform = $this->transform->mapperFirst($absen);
        return response()->jsonSuccess(true, "Berhasil di simpan!", $transform);
    }
}
