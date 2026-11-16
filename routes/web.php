<?php

use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products' , ProductController::class)->except('show');

Route::get('/orders', function (){
    $orders=Order::with('items.product')->latest()->paginate(10);
    return[
        'queries'=>count(DB::getQueryLog()),
        'orders'=>$orders
    ];
});

Route::get('category', function () {
    $categories = Category::withCount('products')->get();
    foreach ($categories as $category) {
        echo $category->name . ':' . $category->products_count;
    }
});