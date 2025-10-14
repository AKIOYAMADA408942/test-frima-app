<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisteredController;
use App\Http\Controllers\TradingChatController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/register',[RegisteredController::class,'store']);
Route::get('/',[ItemController::class,'index'])->name('index');
Route::get('/item/{item_id?}',[ItemController::class,'show'])->name('show');
Route::post('/item/{item_id?}',[ItemController::class,'show']);


Route::middleware('auth','verified')->group(function(){
    Route::get('/sell', [SellController::class, 'sellForm']);
    Route::post('/sell', [SellController::class, 'store']);
    Route::post('/item/{item_id}',[ItemController::class,'comment']);
    Route::post('/like',[ItemController::class,'like']);
    Route::post('/comment',[ItemController::class,'comment']);
    Route::get('/mypage',[UserController::class,'mypage'])->name('mypage');
    Route::get('/mypage/profile', [UserController::class,'edit']);
    Route::post('/mypage/profile',[UserController::class,'update']);
    Route::get('/purchase/{item_id}',[PurchaseController::class, 'purchaseForm'])->name('purchase.form');
    Route::post('/purchase/{item_id}',[PurchaseController::class, 'store']);
    Route::get('/purchase/{item_id}/success',[PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/address/{item_id}',[PurchaseController::class,'addressForm']);
    Route::post('/purchase/address/{item_id}',[PurchaseController::class,'addressEdit']);

    Route::get('/chat/{purchase_id}',[TradingChatController::class,'chatForm']);
    Route::post('/chat/message/{purchase_id}',[TradingChatController::class,'postMessage']);
    Route::post('/chat/edit/{chat_id}',[TradingChatController::class,'editMessage']);
    Route::post('/chat/delete/{purchase_id}',[TradingChatController::class, 'deleteMessage']);
    Route::post('/deal/complete',[TradingChatController::class, 'completeDeal']);
    Route::post('/deal/review/{purchase_id}',[TradingChatController::class, 'reviewUser']);
});
