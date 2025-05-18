<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $map = [
            'credit_card' => 'Fatura',
            'contas' => 'Contas'
        ];
        return [
            'name' => $this->name,
            'url_report' => $this->url_report,
            'url_report_excel' => '',
            'type' =>  $map[$this->type],
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/y H:i'),
        ];
    }
}
