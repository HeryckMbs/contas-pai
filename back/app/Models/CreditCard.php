<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCard extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'owner_name' ,
        'limit',
        'avaliable_limit',
        'number',
        'due_month',
        'due_year',
        'security_code',
        'user_id'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function shoppings(){
        return $this->hasMany(Shopping::class,'credit_card_id','id');
    }

}
