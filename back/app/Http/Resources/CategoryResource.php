<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $types = [
            'expense' => 'Despesa',
            'income' => 'Receita'
        ];
        info($this->id);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $types[$this->type],
            'created_at' => Carbon::parse($this->created_at)->format('d/m/y H:i'),

        ];
    }
}
