<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BillToPay;
use App\Models\BillToRecieve;
use App\Models\Category;
use App\Models\CreditCard;
use App\Models\Departamento;
use App\Models\DepartamentoFuncao;
use App\Models\DepartamentoIntegrante;
use App\Models\Igreja;
use App\Models\Membro;
use App\Models\Shopping;
use App\Models\ShoppingCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::where('email', 'usuario@exemplo.com')->count() == 0) {
            User::create([
                'name' => 'Usuário Padrão',
                'email' => 'usuario@exemplo.com',
                'password' => bcrypt('senha_secreta'),
                'grupo_id' => 1
                // Adicione outros campos, se necessário
            ]);
        }


    }
}
