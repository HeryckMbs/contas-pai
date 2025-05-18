<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillToRecieveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $statusType = [
            'received' => 'Recebido',
            'pending' => 'Pendente'
        ];
       return [
        'id' => $this->id,
        'received_date' => Carbon::parse($this->received_date)->format('d/m/Y'),
        'amount' => "{$this->amount}",
        'status' => $statusType[$this->status],
        'status_code' => $this->status,
        'description' => $this->description,
        'payed' => $this->status == 'received'

       ];
    }
}
