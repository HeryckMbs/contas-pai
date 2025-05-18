<?php

namespace App\Http\Service;

use App\Helpers\DateHelper;
use App\Helpers\Formatter;
use App\Http\Resources\ReportResource;
use App\Jobs\GenerateReport;
use App\Models\BillToPay;
use App\Models\BillToRecieve;
use App\Models\CreditCard;
use App\Models\Report;
use App\Models\Shopping;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportService
{
    public static function getAll($mes = null, $ano = null, $itemsPerPage = 10, $page = 1)
    {
        $datesFilter = DateHelper::getMonthDates($mes, $ano);
        $reports = Report::whereBetween('created_at', [$datesFilter['start'], $datesFilter['end']])
            ->paginate($itemsPerPage, ['*'], 'page', $page);

        return [
            'data' => ReportResource::collection($reports),
            'meta' => [
                'current_page' => $reports->currentPage(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
                'total' => $reports->total(),
            ]
        ];
    }

    public static function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
        ], [
            'name.required' => 'Nome do relatório é obrigatório',
            'type.required' => 'Tipo do relatório é obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();
            $report = Report::create([
                'name' => $request->name,
                'type' => $request->type,
                'mes' => $request->month,
                'ano' => $request->year,
            ]);

            GenerateReport::dispatch($report);

            DB::commit();
            return ['success' => true, 'message' => 'Conta a pagar criada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function destroy(int $id)
    {
        Report::where('id', '=', $id)->delete();
        return ['success' => true, 'message' => 'Relatório excluído com sucesso', 'code' => 200];
    }
    public static function findById(int $id)
    {

        try {



            return ['success' => true, 'message' => '', 'data' => '', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }

    public static function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
        ], [
            'name.required' => 'Nome do relatório é obrigatório',
            'type.required' => 'Tipo do relatório é obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();
            $report = Report::where('id', '=', $id)->update([
                'name' => $request->name,
                'type' => $request->type
            ]);

            GenerateReport::dispatch($report);

            DB::commit();
            return ['success' => true, 'message' => 'Categoria atulizada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function getMonthlyPurchasesByCard($ano, $mes)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();

        $purchases = Shopping::whereIn('credit_card_id', $creditCardsUser)
            ->whereYear('purchase_date', $ano)
            ->whereMonth('purchase_date', $mes)
            ->orderBy('credit_card_id')
            ->orderBy('purchase_date')
            ->get();

        $creditCardNames = CreditCard::whereIn('id', $creditCardsUser)->pluck('name', 'id')->toArray();

        $result = [];

        foreach ($purchases as $purchase) {
            $cardId = $purchase->credit_card_id;
            $cardName = $creditCardNames[$cardId];

            if (!isset($result[$cardName])) {
                $result[$cardName] = [];
            }

            $result[$cardName][] = [
                'purchase_date' => Carbon::parse($purchase->purchase_date)->format('d/m/Y'),
                'description'   => $purchase->description,
                'amount_formatted'        =>  Formatter::formatarParaReal($purchase->amount),
                'amount'        => (float) $purchase->amount,
                'name' => $purchase->name,
                'payed' => $purchase->payed ? 'Sim' : 'Não',
                'installment' => $purchase->installment,
                'category' => $purchase->category->name,
            ];
        }

        return $result;
    }


    public static function generateBillReport($ano, $mes)
    {
        $userId = Auth::id();

        $billsToPay = BillToPay::where('user_id', $userId)
            ->whereYear('due_date', $ano)
            ->whereMonth('due_date', $mes)
            ->orderBy('due_date')
            ->get();

        $billsToReceive = BillToRecieve::where('user_id', $userId)
            ->whereYear('received_date', $ano)
            ->whereMonth('received_date', $mes)
            ->orderBy('received_date')
            ->get();

        $result = [
            'bills_to_pay' => [],
            'bills_to_receive' => []
        ];

        foreach ($billsToPay as $bill) {
            $result['bills_to_pay'][] = [
                'due_date' => Carbon::parse($bill->due_date)->format('d/m/Y'),
                'description' => $bill->description,
                'amount_formatted' => number_format($bill->amount, 2, ',', '.'),
                'amount' => $bill->amount,
                'status' => $bill->status == 'paid' ? 'Pago':'Pendende',
                'nome' =>$bill->name,
                'category' => $bill->category->name ?? 'Sem Categoria',
                'recurrence' => $bill->recurrence,
            ];
        }

        foreach ($billsToReceive as $bill) {
            $result['bills_to_receive'][] = [
                'nome' =>$bill->name,
                'received_date' => Carbon::parse($bill->received_date)->format('d/m/Y'),
                'description' => $bill->description,
                'amount_formatted' => number_format($bill->amount, 2, ',', '.'),
                'amount' => $bill->amount,
                'status' => $bill->status == 'received' ? 'Recebido':'Pendende',
                'category' => $bill->category->name ?? 'Sem Categoria',
                'recurrence' => $bill->recurrence,
            ];
        }

        // Retornar o resultado formatado
        return $result;
    }
}
