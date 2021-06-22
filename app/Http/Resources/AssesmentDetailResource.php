<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssesmentDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'kode_question' => $this->kode_question,
            'question' => $this->question,
            'skor_yes' => $this->skor_yes,
            'skor_no' => $this->skor_no,
            'sort' => $this->sort
        ];
    }
}
