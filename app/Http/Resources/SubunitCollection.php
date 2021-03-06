<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubunitCollection extends ResourceCollection
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
            'subunit' => $this->collection->map(function($subunit) use ($request) {
                return (new SubunitResource($subunit))->toArray($request);
            })
        ];
    }
}
