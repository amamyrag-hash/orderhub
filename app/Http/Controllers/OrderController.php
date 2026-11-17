<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::orderBy("id","desc")->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request )
    {
    
        
       $order = DB::transaction(function () use ($request) {
             $order=Order::create([
                'customer_id'=> 2,
                'total_amount'=> 0
            ]);

            $total=0;
          foreach($request->items as $item) {
            $product = Product::lockForUpdate()->findOrFail($item['product_id']);
            if($product->stock < $item['quantity']){
                throw new Exception('موجودی کافی نیست');
            }
            $total+= $item['quantity'] * $product->price;
            

            OrderItem::create([
                'product_id'=> $item['product_id'],
                'order_id'=>$order->id,
                'quantity'=> $item['quantity'] ,
                'unit_price'=> $product->price
            ]);

            $product->decrement('stock' , $item['quantity']);
          }

          $order->update([
            'total_amount'=>$total
          ]);
           return $order;
        }) ;

        

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        DB::transaction(function() use ($request,$order ){
            $order->update($request->validated());
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
