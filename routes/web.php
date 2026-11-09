<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-log' , function (){
    Log::info('First-log');
    Log::info('Second log');
    return 'ok';
});