<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whichs
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('git/user/{login}', [ \App\Http\Controllers\GitUserController::class, 'getUser' ]);
Route::get('git/users', [ \App\Http\Controllers\GitUserController::class, 'apiGetUsers' ]);

Route::middleware('auth:web')->group(function(){

    Route::post('challenge/hamming/distance', [
        \App\Http\Controllers\Challenge\HammingDistanceController::class, 'calculate'
    ])->name('calc.hamming.distance');

});


Route::middleware('auth:sanctum')->group(function(){
    
});

