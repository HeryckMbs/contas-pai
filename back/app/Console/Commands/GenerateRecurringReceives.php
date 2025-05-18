<?php

namespace App\Console\Commands;

use App\Models\BillToRecieve;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateRecurringReceives extends Command
{
    protected $signature = 'receives:generate-recurring';
    protected $description = 'Generate recurring bills based on their recurrence type';

    public function handle()
    {
        $receives = BillToRecieve::where('received_date', '<=', Carbon::today())->get();

        foreach ($receives as $recieve) {
            $nextDueDate = $recieve->calculateNextDueDate();
            if ($nextDueDate) {
                BillToRecieve::create([
                    'description' => $recieve->description,
                    'amount' => $recieve->amount,
                    'due_date' => $nextDueDate,
                    'status' => 'pending',
                    'recurrence' => $recieve->recurrence,
                    'description' => $recieve->description,
                    'user_id' => $recieve->user_id,
                    'category_id' => $recieve->category->id,

                ]);

                $this->info("Próxima conta criada para: {$recieve->description} com vencimento em {$nextDueDate->format('Y-m-d')}");
            }
        }
    }
}
