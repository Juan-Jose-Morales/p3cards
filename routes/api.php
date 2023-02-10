<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleCardsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route:: prefix('/users')->group(function(){

    Route::put('/register',[UserController::class,'register']);
    Route::post('/login',[UserController::class,'login']);
    Route::post('/recoverPassword',[UserController::class,'recoverPassword']);

});
Route:: prefix('/cards')->group(function(){
    Route::put('/register',[CardsController::class,'register']);
    Route::put('/addCardToTheCollection',[CardController::class,'addCardToTheCollection'])->middleware(['auth:sanctum', 'ability:admin']);
    
});
Route:: prefix('/collections')->group(function(){
    Route::put('/registerCollection',[CollectionController::class,'register']);
});

Route::prefix('/salecards')->group(function(){
    Route::post('/searchCard',[SaleCardsController::class, 'searchCards']);
});
