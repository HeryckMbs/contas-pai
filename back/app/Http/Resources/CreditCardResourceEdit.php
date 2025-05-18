<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardResourceEdit extends JsonResource
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
            'cardName' => $this->name,
            'cardNameTitle' => $this->owner_name,
            'cardLimit' => $this->limit,
            'cardLimitAvaliable' => $this->avaliable_limit,
            'cardNumber' => $this->number,
            'cardMonth' => $this->due_month,
            'cardYear' => $this->due_year,
            'cardCvv' => $this->security_code,
        ];
    }
}
