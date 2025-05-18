<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillToPayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $statusType = [
            'paid' => 'Pago',
            'pending' => 'Pendente'
        ];
       return [
        'id' => $this->id,
        'due_date' => Carbon::parse($this->due_date)->format('d/m/Y'),
        'amount' => "{$this->amount}",
        'status' => $statusType[$this->status],
        'status_code' => $this->status,
        'description' => $this->description,
        'payed' => $this->status == 'paid'
       ];
    }
}
