<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('auth')->group(function (){
    Route::post('login',[AuthController::class,'login']);
});
Route::prefix( 'callback')->group(function (){
    Route::post('contract',[ContractController::class,'callbackContract']);
    Route::post('payment',[PaymentController::class,'callbackPayment']);
    Route::get('getpayment', [PaymentController::class, 'getPayment']);
});
Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('logout',[AuthController::class,'logout']);
    });
    Route::prefix('pay')->group(function (){
        Route::get('pay/{invoice}/{payment_id}',[PaymentController::class,'postPayConfirm'])
            ->where('invoice','[0-9]+')
            ->where('payment_id','[0-9]+');
    });
    Route::prefix('connection')->group(function (){
        Route::prefix('check')->group(function (){
            Route::get('list',[ContractController::class,'listCheck']);
            Route::get('get/{id}',[ContractController::class,'getCheck'])->where('id','[0-9]+');
        });
    });
    Route::prefix('contract')->group(function (){
        Route::get('list',[ContractController::class,'list']);
        Route::post('payed',[ContractController::class,'payed']);
    });
});


