<?php
declare(strict_types= 1);

namespace App\Discount;

use App\Money;
use InvalidArgumentException;

final class PercentageDiscount implements DiscountPolicy
{
    public function __construct(
        public readonly int $percent,
    ){
        if ($percent < 0 || $percent > 100) {
            throw new InvalidArgumentException("Percent must be between0 and 100.");
        }
    }
    public function apply(Money $price): Money
    {
        $discountAmount = intdiv($price->amount * $this->percent , 100);

        return new Money($discountAmount , $price->currency);
    }

}