<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function(){
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::match(['post', 'get'], '/git/users', [ \App\Http\Controllers\GitUserController::class, 'index' ])
        ->name('git.users');

    Route::get('/challenge/hamming/distance', [ 
        \App\Http\Controllers\Challenge\HammingDistanceController::class, 'index' 
    ])->name('challenge.hamming.distance');
    
});

require __DIR__.'/auth.php';
