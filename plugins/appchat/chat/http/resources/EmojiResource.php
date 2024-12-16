<?php namespace AppChat\Chat\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmojiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}