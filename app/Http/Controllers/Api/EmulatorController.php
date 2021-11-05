<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmulatorCollection;
use App\Repository\Emulator\Emulator;

class EmulatorController extends Controller
{
    protected $emulator;

    public function __construct()
    {
        $this->emulator = new Emulator;
    }

    public function getEmulator()
    {
        $data = $this->emulator->getEmulator();

        if(!$data) {
            return response()->jsonError(201, "Data tidak ditemukan!", $data);
        }
        
        $transform = new EmulatorCollection($data);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }
}
