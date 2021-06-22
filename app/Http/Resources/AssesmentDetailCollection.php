<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssesmentDetailCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'assesment_detail' => $this->collection->map(function($assesment) use ($request) {
                return (new AssesmentDetailResource($assesment))->toArray($request);
            })
        ];
    }
}
