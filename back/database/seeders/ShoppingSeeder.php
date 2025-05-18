<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use App\Models\Shopping;
use App\Models\ShoppingCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShoppingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Alimentação',
            'Transporte',
            'Lazer',
            'Saúde',
            'Educação',
            'Vestuário',
            'Casa e Decoração',
            'Eletrônicos',
            'Beleza e Estética',
            'Viagens',
            'Supermercado',
            'Combustível',
            'Entretenimento',
            'Serviços',
            'Assinaturas',
            'Tecnologia',
            'Acessórios',
            'Presentes',
            'Imóveis',
            'Fitness'
        ];
        $categories = [];
        foreach ($categorias as $categoria) {
            $categories[] = ShoppingCategory::create([
                'name' => $categoria
            ])->id;
        }
        $creditCards = [
            [
                'name' => 'Conta Corrente',
                'owner_name' => 'João Silva',
                'limit' => 5000,
                'avaliable_limit' => 3000,
                'number' => '1234-5678',
                'due_month' => 11,
                'due_year' => 2024,
                'security_code' => '123',
                'user_id' => 1
            ],
            [
                'name' => 'Cartão de Crédito',
                'owner_name' => 'Maria Oliveira',
                'limit' => 10000,
                'avaliable_limit' => 8000,
                'number' => '8765-4321',
                'due_month' => 12,
                'due_year' => 2024,
                'security_code' => '456',
                'user_id' => 1
            ],
            [
                'name' => 'Empréstimo Pessoal',
                'owner_name' => 'Carlos Santos',
                'limit' => 15000,
                'avaliable_limit' => 10000,
                'number' => '1122-3344',
                'due_month' => 1,
                'due_year' => 2025,
                'security_code' => '789',
                'user_id' => 1
            ],
            [
                'name' => 'Financiamento',
                'owner_name' => 'Ana Costa',
                'limit' => 30000,
                'avaliable_limit' => 25000,
                'number' => '4433-2211',
                'due_month' => 6,
                'due_year' => 2025,
                'security_code' => '012',
                'user_id' => 1
            ]
        ];

        foreach ($creditCards as $creditCard) {
            CreditCard::create($creditCard);
        }

        $shoppings = [
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 150.75,
                'description' => 'Compra de eletrônicos',
                'name' => 'Loja de Eletrônicos',
                'category_shopping_id' => 1,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 45.20,
                'description' => 'Almoço com amigos',
                'name' => 'Restaurante',
                'category_shopping_id' => 2,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 300.00,
                'description' => 'Compra de móveis',
                'name' => 'Loja de Móveis',
                'category_shopping_id' => 3,
                'payed' => false
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 60.50,
                'description' => 'Assinatura de streaming',
                'name' => 'Serviço de Streaming',
                'category_shopping_id' => 4,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 25.00,
                'description' => 'Café da manhã',
                'name' => 'Cafeteria',
                'category_shopping_id' => 5,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 75.00,
                'description' => 'Compra de roupas',
                'name' => 'Loja de Roupas',
                'category_shopping_id' => 6,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 200.00,
                'description' => 'Viagem de fim de semana',
                'name' => 'Agência de Viagens',
                'category_shopping_id' => 7,
                'payed' => false
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 12.99,
                'description' => 'Filme no cinema',
                'name' => 'Cinema',
                'category_shopping_id' => 1,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 500.00,
                'description' => 'Compra de eletrônicos',
                'name' => 'Loja de Tecnologia',
                'category_shopping_id' => 3,
                'payed' => false
            ],
            [
                'credit_card_id' => 4,
                'purchase_date' => Carbon::now(),
                'amount' => 20.00,
                'description' => 'Transporte',
                'name' => 'Uber',
                'category_shopping_id' => 2,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 90.00,
                'description' => 'Serviço de entrega',
                'name' => 'iFood',
                'category_shopping_id' => 5,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 15.50,
                'description' => 'Livros na livraria',
                'name' => 'Livraria',
                'category_shopping_id' => 9,
                'payed' => false
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 250.00,
                'description' => 'Curso online',
                'name' => 'Plataforma de Cursos',
                'category_shopping_id' => 11,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 70.00,
                'description' => 'Jantar em família',
                'name' => 'Restaurante',
                'category_shopping_id' => 1,
                'payed' => true
            ],
            [
                'credit_card_id' => 1,
                'purchase_date' => Carbon::now(),
                'amount' => 150.00,
                'description' => 'Gasolina',
                'name' => 'Posto de Gasolina',
                'category_shopping_id' => 2,
                'payed' => false
            ]
        ];


        foreach ($shoppings as $shopping) {
            Shopping::create($shopping);
        }
    }
}
