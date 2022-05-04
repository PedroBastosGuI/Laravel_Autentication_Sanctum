<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Models\Product;
use App\Http\Controllers\AuthControl;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::get('/products/search/{nome}', [ProductsController::class, 'search']);
Route::post('/register', [AuthControl::class, 'register']);
Route::post('/login', [AuthControl::class, 'login']);




// criando authentication e protegendo as Rotas de aplicaçõs Spa's

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/products', [ProductsController::class, 'store']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy']);
    Route::post('/logout', [AuthControl::class, 'logout']);

});
