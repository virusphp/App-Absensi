<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperatorCollection;
use App\Repository\Operator\Operator;

class OperatorController extends Controller
{
    protected $operator;

    public function __construct()
    {
        $this->operator = new Operator;
    }

    public function getOperator()
    {
        $data   = $this->operator->getOperator();

        if(!$data) {
            return response()->jsonError(201, "Data tidak ditemukan!", $data);
        }
        
        $transform = new OperatorCollection($data);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }
}
