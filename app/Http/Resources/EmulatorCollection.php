<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmulatorCollection extends ResourceCollection
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
            'setupapp' => $this->collection->map(function($emulator) use ($request) {
                return (new EmulatorResource($emulator))->toArray($request);
            })
        ];
    }
}
