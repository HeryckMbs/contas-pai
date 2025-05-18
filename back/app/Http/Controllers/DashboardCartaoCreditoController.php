<?php

namespace App\Http\Controllers;

use App\Http\Service\DashboardCartaoCreditoService;
use Illuminate\Http\Request;

class DashboardCartaoCreditoController extends Controller
{
    public function getSaldo()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getTotal($mes,$ano);
        return response()->json($groups, 200);
    }

    public function getFavoriteShopping()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getFavoriteShopping($mes,$ano);
        return response()->json($groups, 200);
    }


    public function getRareCreditCard()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getRareCreditCard($mes,$ano);
        return response()->json($groups, 200);
    }

    public function getFavoriteCreditCard()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getFavoriteCreditCard($mes,$ano);
        return response()->json($groups, 200);
    }
    public function getMostShoppingDay()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getMostShoppingDay($mes,$ano);
        return response()->json($groups, 200);
    }

    public function getCardsComparison()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getCardsComparison($ano);
        return response()->json($groups, 200);
    }

    public function getCardsComparisonCategory()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getCardsComparisonCategory($mes,$ano);
        return response()->json($groups, 200);
    }

    public function getCategorySpent()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getCategorySpent($mes,$ano);
        return response()->json($groups, 200);
    }

    public function getMonthlySpentCard()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');

        $groups = DashboardCartaoCreditoService::getMonthlySpentCard($mes,$ano);
        return response()->json($groups, 200);
    }
    
    
}
