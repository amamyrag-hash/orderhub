<?php

declare(strict_types=1);

namespace App\Providers;

use App\Discount\DiscountPolicy;
use App\Discount\FixedAmountDiscount;
use App\Discount\PercentageDiscount;
use App\Money;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

class DiscountServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DiscountPolicy::class, function (): DiscountPolicy {
            $driver = config('orderhub.discount.driver');

            return match ($driver) {
                'percentage' =>new PercentageDiscount (
                    config('orderhub.discount.percentage.percent'),
                ),
                'fixed' => new FixedAmountDiscount(
                    new Money(
                        config('orderhub.discount.fixed.amount'),
                        config('orderhub.discount.fixed.currency'),
                    ),
                ),
                default => throw new InvalidArgumentException(
                    "Unknown discount driver [{$driver}]."
                ),
            };
        });
    }
}