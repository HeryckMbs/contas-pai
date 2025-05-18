<?php

namespace Database\Seeders;

use App\Models\BillToPay;
use App\Models\BillToRecieve;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesPay = [
            [
                'name' => 'Compra de eletrônicos',
                'type' => 'expense'
            ],
            [
                'name' => 'Almoço',
                'type' => 'expense'
            ],
            [
                'name' => 'Assinatura de streaming',
                'type' => 'expense'
            ],
            [
                'name' => 'Compra de móveis',
                'type' => 'expense'
            ],
            [
                'name' => 'Pagamento de aluguel',
                'type' => 'expense'
            ],
            [
                'name' => 'Compra de roupas',
                'type' => 'expense'
            ],
            [
                'name' => 'Pagamento de serviços',
                'type' => 'expense'
            ],
            [
                'name' => 'Jantar fora',
                'type' => 'expense'
            ],
            [
                'name' => 'Viagem de férias',
                'type' => 'expense'
            ],
            [
                'name' => 'Compra de material escolar',
                'type' => 'expense'
            ],
            [
                'name' => 'Cesta básica',
                'type' => 'expense'
            ],
            [
                'name' => 'Conta de luz',
                'type' => 'expense'
            ],
            [
                'name' => 'Conta de água',
                'type' => 'expense'
            ],
            [
                'name' => 'Internet',
                'type' => 'expense'
            ],
            [
                'name' => 'Pagamento de taxa',
                'type' => 'expense'
            ],
        ];

        $categoriesReceive = [
            [
                'name' => 'Salário',
                'type' => 'income'
            ],
            [
                'name' => 'Venda de produtos',
                'type' => 'income'
            ],
            [
                'name' => 'Dividendo de ações',
                'type' => 'income'
            ],
            [
                'name' => 'Venda de carro',
                'type' => 'income'
            ],
            [
                'name' => 'Venda de livros',
                'type' => 'income'
            ],
            [
                'name' => 'Recebimento de comissão',
                'type' => 'income'
            ],
            [
                'name' => 'Renda de aluguel',
                'type' => 'income'
            ],
            [
                'name' => 'Pagamento de serviços prestados',
                'type' => 'income'
            ],
            [
                'name' => 'Retorno de investimento',
                'type' => 'income'
            ],
            [
                'name' => 'Bônus',
                'type' => 'income'
            ],
            [
                'name' => 'Venda de artesanato',
                'type' => 'income'
            ],
            [
                'name' => 'Prêmios',
                'type' => 'income'
            ],
            [
                'name' => 'Reembolso',
                'type' => 'income'
            ],
            [
                'name' => 'Venda de produtos digitais',
                'type' => 'income'
            ],
            [
                'name' => 'Consultoria',
                'type' => 'income'
            ],
        ];


        // Inserir Categorias
        $categoriesToPay = [];
        foreach ($categoriesPay as $category) {
            $categoriesToPay[] = Category::create($category);
        }

        $categoriesToReceive = [];
        foreach ($categoriesReceive as $category) {
            $categoriesToReceive[] = Category::create($category);
        }
        $recorrencias = [
            0=>'UNICA',         
            1=>'SEMANAL',
            2=>'MENSAL',
            3=>'TRIMESTRAL',
            4=>'SEMESTRAL',
            5=>'ANUAL',
        ];
        // Criando transações para BillToPay
        for ($i = 0; $i < 15; $i++) {
            BillToPay::create([
                'user_id' => 1, // Defina o ID do usuário conforme necessário
                'description' => "Transação de pagamento " . ($i + 1),
                'amount' => rand(100, 1000),
                'due_date' => now()->addDays(rand(1, 30)),
                'status' => 'pending', // ou 'paid' conforme a lógica
                'category_id' => $categoriesToPay[array_rand($categoriesToPay)]->id,
                'recurrence' => $recorrencias[random_int(0, 5)]
            ]);
        }

        // Criando transações para BillToReceive
        for ($i = 0; $i < 15; $i++) {
            BillToRecieve::create([
                'user_id' => 1, // Defina o ID do usuário conforme necessário
                'description' => "Transação de recebimento " . ($i + 1),
                'amount' => rand(100, 1000),
                'received_date' => now()->addDays(rand(1, 30)),
                'status' => 'pending', // ou 'received' conforme a lógica
                'category_id' => $categoriesToReceive[array_rand($categoriesToReceive)]->id,
                'recurrence' => $recorrencias[random_int(0, 5)]

            ]);
        }
    }
}
