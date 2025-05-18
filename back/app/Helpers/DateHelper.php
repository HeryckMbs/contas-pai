<?php
namespace App\Helpers;

use Carbon\Carbon;

class DateHelper{
   
    public static function getMonthDates($mes = null, $ano = null)
    {
        if ($mes == null && $ano == null) {
            $startDate = Carbon::now()->startOfMonth()->endOfDay();
            $endDate = Carbon::now()->endOfMonth()->endOfDay();
            return ['start' => $startDate, 'end' => $endDate];
        }

        $startDate = Carbon::createFromDate($ano, $mes, 1)->startOfDay();
        $endDate = $startDate->copy()->endOfMonth()->endOfDay();

        return [
            'start' => $startDate,
            'end' => $endDate,
        ];
    }
}