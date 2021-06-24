<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HasilAssesmentCollection extends ResourceCollection
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
            'hasil_assesment' => $this->collection->map(function($assesment) use ($request) {
                return (new HasilAssesmentResource($assesment))->toArray($request);
            })
        ];
    }
}
