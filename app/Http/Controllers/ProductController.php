<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy("id","desc")->paginate(10);
        return ProductResource::collection($products);

    }

    public function store(ProductRequest $request){
        $product=Product::create($request->validated);
        
        return new ProductResource($product);
 
    }

    public function show($id){
       $product=Product::findOrFail($id);
       return new ProductResource($product);

    }

    public function update(ProductRequest $request, $id){
         $product=Product::findOrFail($id);
         $product->update($request->validated);
    }

    public function destroy($id){
       $product=Product::findOrFail($id);
       $product->delete();
    }
}
