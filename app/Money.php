<?php 
declare(strict_types= 1);
 
namespace App;

use InvalidArgumentException;

final class Money
{
    public function __construct(
        public readonly int $amount,
        public readonly string $currency,
    ){
        if($amount < 0) {
            throw new InvalidArgumentException("Amount cannot be negative.");
        }

    }
    public function add(Money $other): Money
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException(
                 "Connot add {$other->currency} to {$this->currency}."
            );
        }
        return new Money($this->amount+$other->amount, $this->currency);
    }
}