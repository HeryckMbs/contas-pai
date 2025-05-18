<?php
namespace App\Helpers;

class Formatter
{
    public static function formatarParaReal(float $valor): string
    {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }

    public static function debugQuery($query){
        return vsprintf(str_replace(['?'], ['\'%s\''], $query->toSql()), $query->getBindings());
    }
}
