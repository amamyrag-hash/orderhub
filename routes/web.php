<?php

use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/discount-demo' , [DiscountController::class,'show']);