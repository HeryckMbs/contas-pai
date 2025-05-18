<?php

namespace App\Http\Service;

use App\Helpers\DateHelper;
use App\Http\Resources\BillToRecieveResource;
use App\Models\BillToRecieve;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BillToRecieveService
{
    public static function getAll($mes = null,$ano = null,$itemsPerPage = 10,$page = 1)
    {
        $datesFilter = DateHelper::getMonthDates($mes,$ano);
        
        $billsToRecieve = BillToRecieve::whereBetween('received_date', [$datesFilter['start'], $datesFilter['end']])
        ->paginate($itemsPerPage, ['*'], 'page', $page); 
        return [
            'data' => BillToRecieveResource::collection($billsToRecieve),
            'meta' => [
                'current_page' => $billsToRecieve->currentPage(),
                'last_page' => $billsToRecieve->lastPage(),
                'per_page' => $billsToRecieve->perPage(),
                'total' => $billsToRecieve->total(),
            ]
        ];
    }

    public static function create(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'amount' => 'required',
            'status' => 'required',
            'category' => 'required',
            'recurrence' => 'required'
        ], [
            'amount.required' => 'Valor da conta é obrigatório',
            'status.required' => 'Status da conta é obrigatório',
            'category.required' => 'Categoria da conta é obrigatório',
            'recurrence.required' => 'Recorrência é obrigatório'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

            BillToRecieve::create([
                'amount' => $request->amount,
                'received_date' => \Carbon\Carbon::parse($request->received_date)->format('Y-m-d H:i:s'),
                'status' => $request->status,
                'category_id' => $request->category,
                'description' => $request->description,
                'user_id' => Auth::id(),
                'recurrence' => $request->recurrence
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Conta a receber criada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function destroy(int $id){
        BillToRecieve::where('id', '=', $id)->delete();
        return ['data' => [], 'success' => true, 'message' => 'Conta excluída com sucesso'];
    }
    public static function findById(int $id)
    {

        try {

            $BillToRecieve = BillToRecieve::find($id);
            $BillToRecieve['category'] = $BillToRecieve->category_id; 
            return ['success' => true, 'message' => '','data' => $BillToRecieve, 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }

    public static function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'amount' => 'required',
            'received_date' => 'required',
            'status' => 'required',
            'category' => 'required',
        ], [
            'amount.required' => 'Valor da conta é obrigatório',
            'received_date.required' => 'Data de vencimento é obrigatório',
            'status.required' => 'Status da conta é obrigatório',
            'category.required' => 'Categoria da conta é obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

            BillToRecieve::where('id','=',$id)->update([
                'amount' => $request->amount,
                'received_date' =>  \Carbon\Carbon::parse($request->received_date)->format('Y-m-d H:i:s'),
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
    public static function receive(Request $request, $id)
    {


        try {

            BillToRecieve::find($id)->update(['status' => $request->payed ? 'pending':'received',]);

            return ['success' => true, 'message' => 'Compra paga com sucesso!', 'code' => 200,];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }
}
