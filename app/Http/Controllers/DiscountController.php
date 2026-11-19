<?php

namespace App\Http\Controllers;

use App\Discount\DiscountPolicy;
use App\Money;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(
        private readonly DiscountPolicy $discount
    ){}

    public function show()
    {
        $price = new Money(1000 , 'USD');
        $result= $this->discount->apply($price);

        return response()->json([
            'policy'=> $this->discount::class,
            'original_price'=>$price->amount,
            'final_price'=>$result->amount,
            'currency'=>$result->currency
        ]);
    }
}
