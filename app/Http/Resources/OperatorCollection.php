<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OperatorCollection extends ResourceCollection
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
            'operator' => $this->collection->map(function($operator) use ($request) {
                return (new OperatorResource($operator))->toArray($request);
            })
        ];
    }
}
