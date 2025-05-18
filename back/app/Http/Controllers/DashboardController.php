<?php

namespace App\Http\Controllers;

use App\Http\Service\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getSaldo()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardService::getSaldo($mes,$ano);
        return response()->json($groups, 200);
    }

    public function getContasPagas()
    {
        $typeFilter = request()->query('type') ?? 'paid';

        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardService::getContasPagas($typeFilter,$mes,$ano);
        return response()->json($groups, 200);
    }
    public function getContasRecebidas()
    {
        $typeFilter = request()->query('type') ?? 'received';
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardService::getContasRecebidas($typeFilter,$mes,$ano);
        return response()->json($groups, 200);
    }

    public function getPrevisaoSaldo()
    {

        $groups = DashboardService::getPrevisaoSaldo();
        return response()->json($groups, 200);
    }

    public function getSaldoAnual()
    {

        $ano = request()->query('ano') ;

        $groups = DashboardService::getSaldoAnual($ano );
        return response()->json($groups, 200);
    }

    public function getSaldoAnualPagarReceber()
    {
        $ano = request()->query('ano') ;


        $groups = DashboardService::getSaldoAnualPagarReceber($ano );
        return response()->json($groups, 200);
    }

    public function getDespesasCategoria()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardService::getDespesasCategoria($mes,$ano);
        return response()->json($groups, 200);
    }
    public function getReceitasCategoria()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardService::getReceitasCategoria($mes,$ano);
        return response()->json($groups, 200);
    }
}
