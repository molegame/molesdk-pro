<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'icon' => $this->icon,
            'key' => $this->key,
            'secret' => $this->secret,
            'pub_key' => $this->pub_key,
            'pay_callback' => $this->pay_callback,
            'pay_callback_debug' => $this->pay_callback_debug,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
