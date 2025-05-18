<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillToPay extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'due_date',
        'status',
        'category_id',
        'recurrence'
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function calculateNextDueDate()
    {
        switch ($this->recurrence) {
            case 'SEMANAL':
                return Carbon::parse($this->due_date)->addWeek();
            case 'MENSAL':
                return Carbon::parse($this->due_date)->addMonth();
            case 'TRIMESTRAL':
                return Carbon::parse($this->due_date)->addMonths(3);
            case 'SEMESTRAL':
                return Carbon::parse($this->due_date)->addMonths(6);
            case 'ANUAL':
                return Carbon::parse($this->due_date)->addYear();
            default:
                return null;
        }
    }
   
}
