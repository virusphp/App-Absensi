<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssesmentCollection;
use App\Http\Resources\AssesmentDetailCollection;
use App\Repository\Assesment;
use Illuminate\Http\Request;

class AssesmentController extends Controller
{
    public function getAssesment(Assesment $assesment)
    {
        $dataAssessment =  $assesment->getAssesment();

        if (!$dataAssessment) {
            return response()->jsonError(201, "Data tidak ditemukan!", $dataAssessment);
        }

        $transform = new AssesmentCollection($dataAssessment);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }

    public function getAssesmentDetail(Request $request, Assesment $assesment)
    {
        $dataAssessment = $assesment->getAssesmentDetail($request);

        if (!$dataAssessment) {

        }  if (!$dataAssessment) {
            return response()->jsonError(201, "Data tidak ditemukan!", $dataAssessment);
        }

        $transform = new AssesmentDetailCollection($dataAssessment);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }
}