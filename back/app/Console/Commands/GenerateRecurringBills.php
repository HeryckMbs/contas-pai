<?php

namespace App\Console\Commands;

use App\Models\BillToPay;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateRecurringBills extends Command
{
    protected $signature = 'bills:generate-recurring';
    protected $description = 'Generate recurring bills based on their recurrence type';

    public function handle()
    {
        $bills = BillToPay::where('due_date', '<=', Carbon::today())->get();

        foreach ($bills as $bill) {
            $nextDueDate = $bill->calculateNextDueDate();
            dump($nextDueDate);
            if ($nextDueDate) {
                BillToPay::create([
                    'description' => $bill->description,
                    'amount' => $bill->amount,
                    'due_date' => $nextDueDate,
                    'status' => 'pending',
                    'recurrence' => $bill->recurrence,
                    'description' => $bill->description,
                    'user_id' => $bill->user_id,
                    'category_id' => $bill->category->id,



                ]);

                $this->info("Próxima conta criada para: {$bill->description} com vencimento em {$nextDueDate->format('Y-m-d')}");
            }
        }
    }
}
