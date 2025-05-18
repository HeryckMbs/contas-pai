<?php

use App\Http\Controllers\BillToPayController;
use App\Http\Controllers\BillToRecieveController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\DashboardCartaoCredito;
use App\Http\Controllers\DashboardCartaoCreditoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PermissaoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShoppingCategoryController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/login', [UserController::class, 'register'])->name('login');
Route::post('/register',[UserController::class,'register']);

Route::group([
    'middleware' => ['auth:api']
], function () {
    

    Route::apiResource('user', UserController::class); 
    Route::apiResource('group', GrupoController::class); 
    Route::apiResource('permission', PermissaoController::class);     
    Route::apiResource('category',CategoryController::class);
    Route::apiResource('contas-pagar',BillToPayController::class);
    Route::apiResource('contas-receber',BillToRecieveController::class);
    Route::apiResource('credit-card',CreditCardController::class);
    Route::apiResource('shopping',ShoppingController::class);
    Route::apiResource('shopping-category',ShoppingCategoryController::class);
    Route::apiResource('reports',ReportController::class);


    Route::get('credit-card/details/{id}',[CreditCardController::class,'getDetails']);
    Route::patch('/shopping/{id}/pay',[ShoppingController::class,'payShopping']);

    Route::patch('/contas-receber/{id}/receive',[BillToRecieveController::class,'receive']);
    Route::patch('/contas-pagar/{id}/pay',[BillToPayController::class,'pay']);

    

    Route::prefix('dashboard')->controller(DashboardController::class)->group(function(){
        
        Route::get('get-saldo','getSaldo');
        Route::get('get-saldo-anual','getSaldoAnual');
        Route::get('get-saldo-previsao','getPrevisaoSaldo');
        
        Route::get('get-pagar-receber','getSaldoAnualPagarReceber');

        Route::get('get-pagos','getContasPagas');
        Route::get('get-recebidos','getContasRecebidas');

        Route::get('get-total-despesas','getDespesasCategoria');
        Route::get('get-total-receitas','getReceitasCategoria');

        
        
        

    });

    Route::prefix('dashboard-cartao')->controller(DashboardCartaoCreditoController::class)->group(function(){
        
        Route::get('get-total','getSaldo');
        Route::get('get-favorite-card','getFavoriteCreditCard');
        Route::get('get-favorite-shopping','getFavoriteShopping');
        Route::get('get-rare-shopping','getRareCreditCard');
        Route::get('get-most-shopping-day','getMostShoppingDay');
        
        Route::get('get-cards-comparison','getCardsComparison');
        Route::get('get-cards-comparison-category','getCardsComparisonCategory');
        Route::get('get-category-spent','getCategorySpent');

        Route::get('get-monthly-spent-card','getMonthlySpentCard');
        
        
        

    });
    

    Route::get('/notifications',[NotificationsController::class,'getNotifications']);
    Route::put('/read-notifications',[NotificationsController::class,'readNotifications']);

    
});

