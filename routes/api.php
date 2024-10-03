<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ContractController;
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
});
Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('logout',[AuthController::class,'logout']);
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


