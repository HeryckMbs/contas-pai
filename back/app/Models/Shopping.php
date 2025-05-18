<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shopping extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'credit_card_id',
        'purchase_date',
        'amount',
        'description',
        'name',
        'category_shopping_id',
        'payed',
        'installment',
        'fees'
        
    ];

    public function creditCard(){
        return $this->hasOne(CreditCard::class,'id','credit_card_id')->withTrashed();
    }

    public function category(){
        return $this->hasOne(ShoppingCategory::class,'id','category_shopping_id');
    }
}
