<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssesmentCollection;
use App\Http\Resources\AssesmentDetailCollection;
use App\Http\Resources\HasilAssesmentCollection;
use App\Repository\Assesment;
use App\Validation\AssesmentValidation;
use App\Validation\HasilAssesmentValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return response()->jsonError(201, "Data tidak ditemukan!", $dataAssessment);
        }

        $transform = new AssesmentDetailCollection($dataAssessment);

        return response()->jsonSuccess(200, "Data Ditemukan", $transform);
    }

    public function postAssesment(Request $r, AssesmentValidation $valid, Assesment $assesment)
    {
       
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422,  implode(",",$message), $message);
        }

        $saveAssesment = $assesment->simpanAssesement($r);

        if (!$saveAssesment) {
            return response()->jsonError(201, "Data tidak bisa di simpan!" );
        }

        return response()->jsonSuccess(200, "Data Berhasil di simpan", "");

    }

    public function hasilAssesment(Request $r, HasilAssesmentValidation $valid, Assesment $assesment)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonError(422,  implode(",",$message), $message);
        }

        $dataAssesment = $assesment->getHasilAssesment($r);

        if (!$dataAssesment->count()) {
            return response()->jsonError(201, "Data tidak ditemukan");
        }

        $transform = new HasilAssesmentCollection($dataAssesment);

        return response()->jsonSuccess(200, "OK!", $transform);
    }
}