<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AssesmentCollection extends ResourceCollection
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
            'list_assessment' => $this->collection->map(function($assesment) use ($request) {
                return (new AssesmentResource($assesment))->toArray($request);
            })
        ];
    }
}
