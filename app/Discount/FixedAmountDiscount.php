<?php

declare(strict_types= 1);

namespace App\Discount;
use App\Money;

use InvalidArgumentException;

final class FixedAmountDiscount implements DiscountPolicy
{
    public function __construct(
        public readonly Money $discount,
    ){
    }
    public function apply(Money $price): Money
    {
        if($price->currency !== $this->discount->currency){
            throw new InvalidArgumentException(
                "Cannot apply {$this->discount->currency} discount to {$price->currency} price."
            );
        }

        $newAmount= max(0 , $price->amount - $this->discount->amount);
        return new Money($newAmount, $price->currency);
    }
}

