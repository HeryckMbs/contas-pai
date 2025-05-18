<?php

namespace App\Http\Service;

use App\Helpers\DateHelper;
use App\Http\Resources\BillToPayResource;
use App\Models\BillToPay;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BillToPayService
{
    public static function getAll($mes = null,$ano = null,$itemsPerPage = 10,$page = 1)
    {
        $datesFilter = DateHelper::getMonthDates($mes,$ano);
        $billsToPay = BillToPay::whereBetween('due_date', [$datesFilter['start'], $datesFilter['end']])
        ->paginate($itemsPerPage, ['*'], 'page', $page);
        return [
            'data' => BillToPayResource::collection($billsToPay),
            'meta' => [
                'current_page' => $billsToPay->currentPage(),
                'last_page' => $billsToPay->lastPage(),
                'per_page' => $billsToPay->perPage(),
                'total' => $billsToPay->total(),
            ]
        ];
    }

    public static function create(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'amount' => 'required',
            'due_date' => 'required',
            'status' => 'required',
            'category' => 'required',
        ], [
            'amount.required' => 'Valor da conta é obrigatório',
            'due_date.required' => 'Data de vencimento é obrigatório',
            'status.required' => 'Status da conta é obrigatório',
            'category.required' => 'Categoria da conta é obrigatório',
        ]);

        if ($validator->fails()) {
            info('faltou');
            info($validator->getMessageBag());
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

            BillToPay::create([
                'amount' => $request->amount,
                'due_date' =>  \Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s'),
                'status' => $request->status,
                'category_id' => $request->category,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'recurrence' => $request->recurrence
            ]);
            info([
                'amount' => $request->amount,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'category_id' => $request->category,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'recurrence' => $request->recurrence
            ]);
            DB::commit();
            return ['success' => true, 'message' => 'Conta a pagar criada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            info($e);
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function destroy(int $id)
    {
        BillToPay::where('id', '=', $id)->delete();
        return ['data' => [], 'success' => true, 'message' => 'Conta excluída com sucesso'];
    }
    public static function findById(int $id)
    {

        try {

            $billToPay = BillToPay::find($id);
            $billToPay['category'] = $billToPay->category_id;
            return ['success' => true, 'message' => '', 'data' => $billToPay, 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }

    public static function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'amount' => 'required',
            'due_date' => 'required',
            'status' => 'required',
            'category' => 'required',
        ], [
            'amount.required' => 'Valor da conta é obrigatório',
            'due_date.required' => 'Data de vencimento é obrigatório',
            'status.required' => 'Status da conta é obrigatório',
            'category.required' => 'Categoria da conta é obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

            BillToPay::where('id', '=', $id)->update([
                'amount' => $request->amount,
                'due_date' =>\Carbon\Carbon::parse($request->due_date)->format('Y-m-d H:i:s'),
                'status' => $request->status,
                'category_id' => $request->category,
                'description' => $request->description,
                'user_id' => Auth::id()
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Categoria atulizada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function pay(Request $request, $id)
    {

        try {
            BillToPay::where('id', '=', $id)->update(['status' => $request->payed == true ? 'pending' : 'paid',]);
            return ['success' => true, 'message' => 'Compra paga com sucesso!', 'code' => 200,];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }
}
