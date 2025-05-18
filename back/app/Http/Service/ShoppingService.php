<?php

namespace App\Http\Service;

use App\Helpers\DateHelper;
use App\Http\Resources\ShoppingResource;
use App\Http\Resources\ShoppingResourceEdit;
use App\Jobs\GenerateReport;
use App\Models\CreditCard;
use App\Models\Shopping;
use App\Models\ShoppingInstallments;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShoppingService
{
    public static function getAll($mes = null, $ano = null, $itemsPerPage = 10,$page= 1)
    {
        $datesFilter = DateHelper::getMonthDates($mes, $ano);

        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->withTrashed()->pluck('id')->toArray();
        $shoppings = Shopping::whereBetween('purchase_date', [$datesFilter['start'], $datesFilter['end']])
            ->whereIn('credit_card_id', $creditCardsUser)
            ->paginate($itemsPerPage, ['*'], 'page', $page);
            return  [
            'data' => ShoppingResource::collection($shoppings),
            'meta' => [
                'current_page' => $shoppings->currentPage(),
                'last_page' => $shoppings->lastPage(),
                'per_page' => $shoppings->perPage(),
                'total' => $shoppings->total(),
            ]
        ];
    }

    public static function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'credit_card' => 'required',
            'purchase_date' => 'required',
            'amount' => 'required',
            'name' => 'required',
            'category' => 'required'

        ], [
            'credit_card.required' => 'Cartão de crédito é obrigatório',
            'purchase_date.required' => 'Data de compra é obrigatório',
            'amount.required' => 'Valor é obrigatório',
            'name.required' => 'Nome da compra é obrigatório',
            'category.required' => 'Categoria da compra é obrigatória'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();


            if ($request->installments > 1) {
                $purchaseDate = Carbon::parse($request->purchase_date);
                foreach (range(1, $request->installments) as $parcela) {
                    Shopping::create([
                        'credit_card_id' => $request->credit_card,
                        'purchase_date' => $purchaseDate,
                        'amount' => $request->amount / $request->installments,
                        'name' => $request->name,
                        'description' => $request->description,
                        'category_shopping_id' => $request->category,
                        'installment' => $parcela
                    ]);
                    $purchaseDate->addMonth();
                }
            } else {

                Shopping::create([
                    'credit_card_id' => $request->credit_card,
                    'purchase_date' => $request->purchase_date,
                    'amount' => $request->amount,
                    'name' => $request->name,
                    'description' => $request->description,
                    'category_shopping_id' => $request->category
                ]);
            }

            $creditCard = CreditCard::find($request->credit_card);
            $creditCard->update([
                'avaliable_limit' => $creditCard->avaliable_limit - $request->amount
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Conta a pagar criada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function destroy(int $id)
    {
        Shopping::where('id', '=', $id)->delete();
        return ['data' => [], 'success' => true, 'message' => 'Compra excluída com sucesso'];
    }
    public static function findById(int $id)
    {

        try {
            $creditCardResource = new ShoppingResourceEdit(Shopping::findOrFail($id));

            return ['success' => true, 'message' => '', 'data' => $creditCardResource, 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }

    public static function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'credit_card' => 'required',
            'purchase_date' => 'required',
            'amount' => 'required',
            'name' => 'required',

        ], [
            'credit_card.required' => 'Cartão de crédito é obrigatório',
            'purchase_date.required' => 'Data de compra é obrigatório',
            'amount.required' => 'Valor é obrigatório',
            'name.required' => 'Nome da compra é obrigatório',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

            Shopping::where('id', '=', $id)->update([
                'credit_card_id' => $request->credit_card,
                'purchase_date' => $request->purchase_date,
                'amount' => $request->amount,
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category
            ]);



            DB::commit();
            return ['success' => true, 'message' => 'Categoria atulizada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }
    public static function payShopping(Request $request, $id)
    {


        try {

            $shop = Shopping::find($id)->first();
            $shop->update(['payed' => $request->payed,]);

            $oldLimit = $shop->creditCard->avaliable_limit;
            $newAvaliableLimit = $oldLimit + ($request->payed ?  $shop->amount : $shop->amount * -1);

            $shop->creditCard->update(['avaliable_limit' => $newAvaliableLimit]);
            return ['success' => true, 'message' => 'Compra paga com sucesso!', 'code' => 200,];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }
}
