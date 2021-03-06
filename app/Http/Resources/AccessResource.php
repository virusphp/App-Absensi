<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessResource extends JsonResource
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
            'access' =>  [
                'nama'       => $this->nama,
                'username'   => $this->username,
                'email'      => $this->email,
                'phone'      => $this->phone,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'api_token' => $this->api_token,
        ];
    }
}
