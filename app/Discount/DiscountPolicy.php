<?php 
declare(strict_types= 1);

namespace App\Discount;

use App\Money;

interface DiscountPolicy
{
    public function apply(Money $price): Money;
}