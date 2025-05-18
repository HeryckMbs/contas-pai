<?php

namespace App\Console\Commands;

use App\Http\Service\NotificationService;
use App\Models\BillToPay;
use App\Models\Notifications;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class NotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cadastra notificações';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoje = Carbon::today();
        $proximosDias = $hoje->copy()->addDays(7);
        // Busca registros que vencem entre hoje e daqui a 7 dias
        $registrosProximos = BillToPay::where('status','=','pending')->whereBetween('due_date', [$hoje, $proximosDias])->get();    

        foreach($registrosProximos as $bill){
            NotificationService::createPagamentoPendente($bill);
        }
    }
}
