<?php

namespace App\Http\Service;

use App\Http\Resources\CreditCardDetailsResouce;
use App\Http\Resources\CreditCardResource;
use App\Http\Resources\CreditCardResourceEdit;
use App\Models\CreditCard;
use App\Models\Shopping;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreditCardService
{
    public static function getAll($itemsPerPage = 10,$page= 1)
    {
        $creditsCard = CreditCard::where('user_id',Auth::id())
        ->paginate($itemsPerPage, ['*'], 'page', $page);

        return [
            'data' => CreditCardResource::collection($creditsCard),
            'meta' => [
                'current_page' => $creditsCard->currentPage(),
                'last_page' => $creditsCard->lastPage(),
                'per_page' => $creditsCard->perPage(),
                'total' => $creditsCard->total(),
            ]
        ];
    }

    public static function create(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'cardName' => 'required',
            'cardNameTitle' => 'required',
            'cardLimit' => 'required',
            'cardNumber' => 'required',
            'cardMonth' => 'required',
            'cardYear' => 'required',
            'cardCvv' => 'required',
        ], [
            'cardName.required' => 'Nome do cartão é obrigatório',
            'cardNameTitle.required' => 'Nome do titular é obrigatório',
            'cardLimit.required' => 'Limite do cartão é obrigatório',
            'cardNumber.required' => 'Número do cartão é obrigatório',
            'cardMonth.required' => 'Mês de vencimento é obrigatório',
            'cardYear.required' => 'Ano de vencimento é obrigatório',
            'cardCvv.required' => 'Código de segurança é obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();
            CreditCard::create([
                'name' => $request->cardName,
                'owner_name' => $request->cardNameTitle,
                'limit' => $request->cardLimit,
                'avaliable_limit' => $request->cardLimit,
                'number' => trim( $request->cardNumberNotMask),
                'due_month' => $request->cardMonth,
                'due_year' => $request->cardYear,
                'security_code' => $request->cardCvv,
                'user_id' => Auth::id()
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Cartão de cŕedito criado com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();

            return ['success' => false, 'message' => $e->getMessage(), 'request' => [
                'name' => $request->cardName,
                'owner_name' => $request->cardNameTitle,
                'limit' => $request->cardLimit,
                'avaliable_limit' => $request->cardLimit,
                'number' => trim( $request->cardNumberNotMask),
                'due_month' => $request->cardMonth,
                'due_year' => $request->cardYear,
                'security_code' => $request->cardCvv,
                'user_id' => Auth::id()
            ], 'code' => $e->getCode()];
        }
    }

    public static function destroy(int $id)
    {
        Shopping::where('credit_card_id','=',$id)->update(['payed'=> true]);
        CreditCard::where('id', '=', $id)->delete();
        return ['data' => [], 'success' => true, 'message' => 'Conta excluída com sucesso'];
    }
    public static function findById(int $id)
    {

        try {

            $creditCard = new CreditCardResourceEdit(CreditCard::find($id));
            return ['success' => true, 'message' => '', 'data' => $creditCard, 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }

    public static function getDetails(int $id){

        try {

            $creditCard = new CreditCardDetailsResouce(CreditCard::find($id));
            return ['success' => true, 'message' => '', 'data' => $creditCard, 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }

    public static function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [

            'cardName' => 'required',
            'cardNameTitle' => 'required',
            'cardLimit' => 'required',
            'cardNumber' => 'required',
            'cardMonth' => 'required',
            'cardYear' => 'required',
            'cardCvv' => 'required',
        ], [
            'cardName.required' => 'Nome do cartão é obrigatório',
            'cardNameTitle.required' => 'Nome do titular é obrigatório',
            'cardLimit.required' => 'Limite do cartão é obrigatório',
            'cardNumber.required' => 'Número do cartão é obrigatório',
            'cardMonth.required' => 'Mês de vencimento é obrigatório',
            'cardYear.required' => 'Ano de vencimento é obrigatório',
            'cardCvv.required' => 'Código de segurança é obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();
            $oldCreditCard = CreditCard::where('id', '=', $id)->first();

            $newAvaliableLimit = $oldCreditCard->limit;

            if($oldCreditCard->limit != $request->cardLimit){
                $newAvaliableLimit = $oldCreditCard->avaliable_limit + ($request->cardLimit - $oldCreditCard->limit);
            }
            $oldCreditCard->update([
                'name' => $request->cardName,
                'owner_name' => $request->cardNameTitle,
                'limit' => $request->cardLimit,
                'avaliable_limit' => $newAvaliableLimit,
                'number' => trim( $request->cardNumberNotMask),
                'due_month' => $request->cardMonth,
                'due_year' => $request->cardYear,
                'security_code' => $request->cardCvv,
                'user_id' => Auth::id()
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Categoria atulizada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }
}
