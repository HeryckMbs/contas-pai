<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $ultimosQuatro = substr($this->number, -4);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_name' => $this->owner_name,
            'limit' => $this->limit,
            'avaliable_limit' => $this->avaliable_limit,
            'number' => $this->maskNumberCreditCard($this->number),
            'title_name' => "{$this->name} - Final: {$ultimosQuatro}"

        ];
    }

    private function maskNumberCreditCard(string $numeroCartao)
    {


        $ultimosQuatro = substr($numeroCartao, -4);

        $mascarado = str_repeat('**** ', intdiv(strlen($numeroCartao) - 4, 4));

        $mascarado = rtrim($mascarado) . ' ' . $ultimosQuatro;

        return $mascarado;
    }
}
