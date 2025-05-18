<?php

namespace App\Http\Service;

use App\Models\CreditCard;
use App\Models\Shopping;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\DateHelper;
use App\Helpers\Formatter;
use App\Models\ShoppingCategory;
use Carbon\Carbon;

class DashboardCartaoCreditoService
{
    public static function getTotal($mes = null, $ano = null)
    {
        $datesFilter = DateHelper::getMonthDates($mes, $ano);

        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();

        $totalCredito = Shopping::whereBetween('purchase_date', [$datesFilter['start'], $datesFilter['end']])
            ->whereIn('credit_card_id', $creditCardsUser)
            ->sum('amount');

        return ['success' => true, 'data' => Formatter::formatarParaReal($totalCredito)];
    }
    public static function getFavoriteShopping($mes = null, $ano = null)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();
        $datesFilter = DateHelper::getMonthDates($mes, $ano);

        $mostFrequentProduct = Shopping::select('category_shopping_id')
            ->whereBetween('purchase_date', [$datesFilter['start'], $datesFilter['end']])
            ->whereIn('credit_card_id', $creditCardsUser)
            ->groupBy('category_shopping_id')
            ->orderByRaw('COUNT(*) desc')->first();

        $mostFrequentCategory = $mostFrequentProduct != null > 0 ? ShoppingCategory::find($mostFrequentProduct)->first()->name : 'Nenhum';
        return ['success' => true, 'data' => $mostFrequentCategory];
    }

    public static function getRareCreditCard($mes = null, $ano = null)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();
        $datesFilter = DateHelper::getMonthDates($mes, $ano);

        $mostRareProduct = Shopping::select('credit_card_id')
            ->whereIn('credit_card_id', $creditCardsUser)
            ->whereBetween('purchase_date', [$datesFilter['start'], $datesFilter['end']])
            ->groupBy('credit_card_id') // Agrupar por credit_card_id
            ->orderByRaw('COUNT(*) ASC') // Contar e ordenar em ordem crescente
            ->first();

        $mostRareProduct = $mostRareProduct ? CreditCard::find($mostRareProduct->credit_card_id)->name : 'Nenhum'; // Corrigido para acessar credit_card_id
        return ['success' => true, 'data' => $mostRareProduct];
    }

    public static function getFavoriteCreditCard($mes = null, $ano = null)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();
        $datesFilter = DateHelper::getMonthDates($mes, $ano);

        $mostFavoriteProduct = Shopping::select('credit_card_id')
            ->whereIn('credit_card_id', $creditCardsUser)
            ->whereBetween('purchase_date', [$datesFilter['start'], $datesFilter['end']])
            ->groupBy('credit_card_id') // Agrupar por credit_card_id
            ->orderByRaw('COUNT(*) desc')
            ->first();

        $mostFavoriteProduct = $mostFavoriteProduct ? CreditCard::find($mostFavoriteProduct->credit_card_id)->name : 'Nenhum'; // Corrigido para acessar credit_card_id
        return ['success' => true, 'data' => $mostFavoriteProduct];
    }

    public static function getMostShoppingDay($mes = null, $ano = null)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();
        $datesFilter = DateHelper::getMonthDates($mes, $ano);

        $mostActiveDay = Shopping::selectRaw('DATE(purchase_date) as purchase_day, COUNT(*) as total_purchases')
            ->whereBetween('purchase_date', [$datesFilter['start'], $datesFilter['end']])
            ->groupBy('purchase_day')
            ->whereIn('credit_card_id', $creditCardsUser)
            ->orderBy('total_purchases', 'desc')
            ->first();

        $date = 'Nenhum';
        if ($mostActiveDay != null) {
            $date = Carbon::parse($mostActiveDay->purchase_day)->format('d/m/Y');
        }
        return ['success' => true, 'data' => $date];
    }
    public static function getCardsComparison($ano = null)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();

        $monthlyExpenses = Shopping::selectRaw('
                credit_card_id, 
                SUM(amount) as total_spent,
                to_char(purchase_date, \'MM\') as month
            ')
            ->whereIn('credit_card_id', $creditCardsUser)
            ->whereYear('purchase_date', $ano)
            ->groupBy('credit_card_id', 'month')
            ->orderBy('month')
            ->get();

        $creditCardNames = CreditCard::whereIn('id', $creditCardsUser)->pluck('name', 'id')->toArray();

        $result = [];
        foreach ($monthlyExpenses as $expense) {
            $cardId = $expense->credit_card_id;
            $month = $expense->month;


            if (!isset($result[$cardId])) {
                $result[$cardId] = [
                    'name' => $creditCardNames[$cardId],
                    'data' => array_fill(0, 12, 0)
                ];
            }

            $result[$cardId]['data'][$month - 1] = (float)$expense->total_spent;
        }

        $result = array_values($result);

        return ['success' => true, 'data' => $result];
    }

    public static function getCardsComparisonCategory($mes = '', $ano = null)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();

        $annualCategoryExpenses = Shopping::selectRaw('
                credit_card_id, 
                category_shopping_id,
                SUM(amount) as total_spent
            ')
            ->whereIn('credit_card_id', $creditCardsUser)
            ->whereYear('purchase_date', $ano)
            ->whereMonth('purchase_date', $mes)
            ->groupBy('credit_card_id', 'category_shopping_id')
            ->orderBy('credit_card_id','desc')
            ->get();
        
        $creditCardNames = CreditCard::whereIn('id', $creditCardsUser)->pluck('name', 'id')->toArray();
        $categoryNames = ShoppingCategory::whereIn('id', $annualCategoryExpenses->pluck('category_shopping_id')->toArray())->pluck('name', 'id')->toArray();
        
        $result = [];
        $categoryList = [];
        
        // Estrutura para armazenar os gastos por cartão
        foreach ($annualCategoryExpenses as $expense) {
            $cardId = $expense->credit_card_id;
            $categoryId = $expense->category_shopping_id;
        
            // Inicializa o cartão se não existir
            if (!isset($result[$cardId])) {
                $result[$cardId] = [
                    'name' => $creditCardNames[$cardId],
                    'data' => array_fill(0, count($categoryNames), 0) // Inicializa com zeros
                ];
            }
        
            // Atualiza o total gasto na categoria correta
            $index = array_search($categoryNames[$categoryId], $categoryList);
            if ($index === false) {
                // Se a categoria não existir, adiciona à lista e encontra o novo índice
                $categoryList[] = $categoryNames[$categoryId];
                $index = count($categoryList) - 1; // Novo índice
            }
        
            $result[$cardId]['data'][$index] = (float) $expense->total_spent;
        }
        
        // Garante que o resultado final esteja no formato correto
        $result = array_values($result);
        
        // Reorganiza os dados para Highcharts
        $seriesData = [];
        foreach ($result as $card) {
            $seriesData[] = [
                'name' => $card['name'],
                'data' => $card['data']
            ];
        }
        
        return [
            'success' => true,
            'data' => $seriesData, 
            'categories' => $categoryList 
        ];
        
    }

    public static function getCategorySpent($mes = null, $ano = null)
    {
        $year = $ano; //
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();

        $categoryExpenses = Shopping::selectRaw('
        category_shopping_id, 
        SUM(amount) as total_spent
    ')
            ->whereIn('credit_card_id', $creditCardsUser)
            ->whereMonth('purchase_date', $mes)
            ->whereYear('purchase_date', $year)
            ->groupBy('category_shopping_id')
            ->orderBy('category_shopping_id','desc')
            ->get();
        $categoryNames = ShoppingCategory::whereIn('id', $categoryExpenses->pluck('category_shopping_id')->toArray())->pluck('name', 'id')->toArray();

        $result = [];
        foreach ($categoryExpenses as $expense) {
            $categoryId = $expense->category_shopping_id;

            // Adiciona os gastos ao resultado com o nome da categoria
            $result[$categoryId]['category_name'] = $categoryNames[$categoryId];
            $result[$categoryId]['total_spent'] = (float) $expense->total_spent;
        }

        // Retorna o resultado final
        return ['success' => true, 'data' => array_values($result)];
    }
    public static function getMonthlySpentCard($mes = null, $ano = null)
    {
        $creditCardsUser = CreditCard::where('user_id', '=', Auth::id())->pluck('id')->toArray();

        $monthlyExpenses = Shopping::selectRaw('
                credit_card_id, 
                SUM(amount) as total_spent,
                EXTRACT(MONTH FROM purchase_date) as month
            ')
            ->whereIn('credit_card_id', $creditCardsUser)
            ->whereYear('purchase_date', $ano)
            ->whereMonth('purchase_date', $mes)
            ->groupBy('credit_card_id', 'month')
            ->orderBy('credit_card_id', 'desc')
            ->get();
    
        $creditCardNames = CreditCard::whereIn('id', $creditCardsUser)->pluck('name', 'id')->toArray();
    
        $result = [];
    
        foreach ($monthlyExpenses as $expense) {
            $cardId = $expense->credit_card_id;
            $month = $expense->month - 1; 
    
            if (!isset($result[$cardId])) {
                $result[$cardId] = [
                    'name' => $creditCardNames[$cardId],
                    'data' => 0
                ];
            }
    
            $result[$cardId]['data'] += (float) $expense->total_spent;
        }
    
        return ['success' => true, 'data' => array_values($result)];
    }
    
}
