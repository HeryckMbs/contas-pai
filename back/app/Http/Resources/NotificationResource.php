<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => $this->url,
            'is_read' => $this->is_read,
            'sent_at' => Carbon::parse($this->sent_at)->format('d/m/y H:i'),
            'read_at' => Carbon::parse($this->read_at)->format('d/m/y H:i'),
        ];
    }
}
