<?php namespace AppChat\Chat\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->user->username,
            'message' => $this->message ? $this->message : NULL,
            'reply to' => $this->parentMessage ? $this->parentMessage->message : NULL,
            'emoji' => $this->emoji ? $this->emoji->name : NULL,
            'file' => $this->file_path ? $this->file_path : NULL
        ];

        return array_filter($data, 
            function ($value) {
                return !is_null($value);
            }
        );
    }
}