<?php

namespace App\Http\Resources;

use App\Models\Shopping;
use App\Models\ShoppingCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCardDetailsResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $shoppings = $this->shoppings;
        $categories = [];
        foreach ($shoppings as $shop) {
            $categories[] = $shop->category->name;
        }
        $mostFrequentProduct = Shopping::select('category_shopping_id')
            ->where('credit_card_id', '=', $this->id)
            ->groupBy('category_shopping_id')
            ->orderByRaw('COUNT(*) DESC')->first();
       
        $mostFrequentCategory = $mostFrequentProduct != null > 0 ? ShoppingCategory::find($mostFrequentProduct)->first()->name : 'Nenhum';
        $shoppings = Shopping::where('credit_card_id', '=', $this->id)
            ->limit(100)->get();
        $shoppings = $shoppings->map(function ($element) {
            return  [
                'name' => $element->name,
                'purchase_date' => Carbon::parse($this->purchase_date)->format('d/m/Y'),
                'amount' => $element->amount,
                'category' => $element->category->name,
                'installments_qtd' => $element->installment
            ];
        });
        $shoppingsThisMonth = Shopping::where('credit_card_id', '=', $this->id)
            ->whereMonth('purchase_date', Carbon::now()->month)
            ->whereYear('purchase_date', Carbon::now()->year)
            ->limit(100)
            ->get()
            ->count();
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
            'user' => $this->user->name,
            'shoppings' => [
                'qtd' => $this->shoppings->count(),
                'most_bought' => $mostFrequentCategory,
                'categories' => array_unique($categories),
                'shoppings' => $shoppings,
                'shoppingsThisMonthQtd' => $shoppingsThisMonth,
                'shoppingsThisMonth' => [
                    
                ]
            ]
        ];
    }
}
