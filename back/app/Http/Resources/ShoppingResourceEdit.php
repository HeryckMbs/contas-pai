<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingResourceEdit extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        $creditCard = $this->creditCard;
        return [
            'id' => $this->id,
            'credit_card' => $creditCard->id, 
            'purchase_date' => Carbon::parse($this->purchase_date)->format('d/m/Y'),
            'amount' => $this->amount,
            'name' => $this->name,
            'category' => $this->category->id
        ];
    }
}
