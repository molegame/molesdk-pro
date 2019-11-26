<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelConfigResource extends JsonResource
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
            'channel_id' => $this->channel_id,
            'bundle_id' => $this->bundle_id,
            'icon' => $this->icon,
            'splashes' => $this->splashes,
            'goods' => $this->goods,
            'params' => $this->params,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
