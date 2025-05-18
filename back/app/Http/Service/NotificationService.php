<?php

namespace App\Http\Service;

use App\Http\Resources\NotificationResource;
use App\Models\BillToPay;
use App\Models\Notifications;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotificationService
{

    public static function getAll()
    {
        $notifications = Notifications::where('user_id', '=', Auth::id())->where('is_read', '=', false)->paginate(10);
        return [
            'data' => NotificationResource::collection($notifications),
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ]
        ];
    }

    public static function createPagamentoPendente(BillToPay $bill)
    {



        try {
            $dateFormatted = Carbon::parse($bill->due_date)->format('d/m/Y');
            DB::beginTransaction();
            Notifications::create([
                'user_id' => $bill->user_id,
                'title' => 'Pagamento Pendente',
                'message' => 'Atenção! Você tem uma conta pendente para o dia '.$dateFormatted,
                'type' => 'warning',
                'url' => 'contas-pagar/edit/'.$bill->id,
                'is_read' => false,
                'sent_at' => Carbon::now(),
                'read_at' => null,
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Notificação criada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => '', 'code' => $e->getCode()];
        }
    }



    public static function readNotifications(Request $request)
    {


        

        try {
            DB::beginTransaction();
            Notifications::whereIn('id',$request->notifications)->update([
                'is_read' => true,
                'read_at' => Carbon::now()
            ]);
        

            DB::commit();
            return ['success' => true, 'message' => 'Categoria atulizada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }
}
