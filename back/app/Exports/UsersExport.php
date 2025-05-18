<?php 


namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;

class UsersExport implements FromCollection
{
    public function collection()
    {
        $header = ['Coluna1','Coluna3','Coluna3','Coluna5',];
        $data = [[4, 5, 6],[4, 5, 6],[4, 5, 6]];
        return new Collection([
            $header,
            $data
        ]);
    }
}