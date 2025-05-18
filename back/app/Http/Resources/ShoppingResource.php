<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $creditCard = $this->creditCard;
        $ultimosQuatro = substr($creditCard->number, -4);

        return [
            'id' => $this->id,
            'credit_card' => $creditCard->name . ' - ' . $ultimosQuatro,
            'credit_card_id' => $creditCard->id, 
            'purchase_date' => Carbon::parse($this->purchase_date)->format('d/m/Y'),
            'amount' => $this->amount,
            'name' => $this->name,
            'category' => $this->category->name,
            'payed' => $this->payed,
            'installment' => $this->installment

            // 'parcelado' => $this->installments->isNotEmpty() ? ''
        ];
    }
}
