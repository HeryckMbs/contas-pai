<?php

namespace App\Http\Service;

use App\Helpers\DateHelper;
use App\Helpers\Formatter;
use App\Models\BillToPay;
use App\Models\BillToRecieve;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class DashboardService
{
    public static function getSaldo($mes = null, $ano = null)
    {
        $dates = self::getMonthDates($mes,$ano);
        $contasPagar = BillToPay::where('status', '=', 'paid')
            ->whereBetween('due_date', [$dates['start'], $dates['end']])
            ->where('user_id', '=', Auth::id())->sum('amount');
        $contasReceber = BillToRecieve::where('status', '=', 'received')
            ->whereBetween('received_date', [$dates['start'], $dates['end']])
            ->where('user_id', '=', Auth::id())->sum('amount');
        $saldo = $contasReceber - $contasPagar;

        return ['success' => true, 'data' => Formatter::formatarParaReal($saldo),];
    }

    public static function getPrevisaoSaldo($mes = null, $ano = null)
    {
        $dates = self::getMonthDates($mes,$ano);

        $contasPagar = BillToPay::where('status', '=', 'pending')
            ->whereBetween('due_date', [$dates['start'], $dates['end']])
            ->where('user_id', '=', Auth::id())->sum('amount');
        $contasReceber = BillToRecieve::where('status', '=', 'pending')
            ->whereBetween('received_date', [$dates['start'], $dates['end']])
            ->where('user_id', '=', Auth::id())->sum('amount');
        $saldo = $contasReceber - $contasPagar;

        return ['success' => true, 'data' => Formatter::formatarParaReal($saldo),];
    }

    public static function getContasPagas(string $filter = 'paid', $mes = null, $ano = null)
    {
        $dates = self::getMonthDates($mes,$ano);

        $contasPagar = BillToPay::where('status', '=', $filter)
            ->whereBetween('due_date', [$dates['start'], $dates['end']])
            ->where('user_id', '=', Auth::id())->sum('amount');
        return ['success' => true, 'data' => Formatter::formatarParaReal($contasPagar),];
    }
    public static function getContasRecebidas(string $filter = 'received', $mes = null, $ano = null)
    {
        $dates = self::getMonthDates($mes,$ano);

        $contasReceber = BillToRecieve::where('status', '=', $filter)
            ->whereBetween('received_date', [$dates['start'], $dates['end']])
            ->where('user_id', '=', Auth::id())->sum('amount');
        return ['success' => true, 'data' => Formatter::formatarParaReal($contasReceber),];
    }

    private static function getMonthDates($mes = null, $ano = null)
    {
       return DateHelper::getMonthDates($mes,$ano);
    }

    public static function getSaldoAnual($ano = null)
    {


        $start = $ano != null  ? Carbon::createFromDate($ano, 1, 1): Carbon::now()->startOfYear();
        $data = [];
        for ($i = 0; $i < 12; $i++) {
            $monthStart = $start->copy()->addMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            $contasPagar = BillToPay::whereBetween('due_date', [$monthStart, $monthEnd])
                ->where('user_id', '=', Auth::id())
                ->sum('amount');

            $contasReceber = BillToRecieve::whereBetween('received_date', [$monthStart, $monthEnd])
                ->where('user_id', '=', Auth::id())
                ->sum('amount');


            $data[$i] = $contasReceber - $contasPagar;
        }
        return ['success' => true, 'data' => $data,];
    }
    public static function getSaldoAnualPagarReceber($ano = null)
    {


        $start = $ano != null  ? Carbon::createFromDate($ano, 1, 1): Carbon::now()->startOfYear();
        $dataReceber = [];
        $dataPagar = [];
        for ($i = 0; $i < 12; $i++) {
            $monthStart = $start->copy()->addMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();

            $contasPagar = BillToPay::whereBetween('due_date', [$monthStart, $monthEnd])
                ->where('user_id', '=', Auth::id())
                ->sum('amount');

            $contasReceber = BillToRecieve::whereBetween('received_date', [$monthStart, $monthEnd])
                ->where('user_id', '=', Auth::id())
                ->sum('amount');

            $dataReceber[$i] = floatval($contasReceber);
            $dataPagar[$i] = floatval($contasPagar);
        }
        return ['success' => true, 'data' => ['receber' => $dataReceber, 'pagar' => $dataPagar],];
    }

    public static function getDespesasCategoria($mes = null, $ano = null)
    {
        $dates = self::getMonthDates($mes,$ano);

        $data = BillToPay::selectRaw('category_id, categories.name as categoria, CAST(sum(amount) AS float) as total')
            ->join('categories', 'categories.id', '=', 'bill_to_pays.category_id')
            ->groupBy('category_id', 'categories.name')
            ->whereBetween('due_date', [$dates['start'], $dates['end']])
            ->get()
            ->map(function ($item) {
                $item->total = (float) $item->total;
                return $item;
            });
        return ['success' => true, 'data' => $data,];
    }
    public static function getReceitasCategoria($mes = null, $ano = null)
    {
        $dates = self::getMonthDates($mes,$ano);

        $data = BillToRecieve::selectRaw('bill_to_recieves.category_id, categories.name as categoria, CAST(sum(bill_to_recieves.amount) AS float) as total')
            ->join('categories', 'categories.id', '=', 'bill_to_recieves.category_id')
            ->whereBetween('received_date', [$dates['start'], $dates['end']])
            ->groupBy('bill_to_recieves.category_id', 'categories.name')
            ->get()
            ->map(function ($item) {
                $item->total = (float) $item->total;
                return $item;
            });
        return ['success' => true, 'data' => $data,];
    }
}
