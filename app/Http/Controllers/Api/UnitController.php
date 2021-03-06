<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubunitCollection;
use App\Repository\Unit\Subunit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $subunit;

    public function __construct()
    {
        $this->subunit = new Subunit;
    }

    public function getSubunit()
    {
        $data   = $this->subunit->getSubunit();

        if(!$data) {
            return response()->jsonError(201, "Data tidak ditemukan!", $data);
        }
        
        $transform = new SubunitCollection($data);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }
}
