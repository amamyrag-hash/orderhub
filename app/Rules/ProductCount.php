<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Pest\Support\Arr;

class ProductCount implements ValidationRule , DataAwareRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */

    protected array $data = [];

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productKey = preg_replace("/\.quantity$/",".product_id", $attribute);

        $productID = Arr::get($this->data, $productKey);

        $product = Product::find(Arr::get($this->data, $productID));

        if(! $product || $value > $product->stock)
            {
                $fail("این محصول یه تعداد کافی وجود ندارد");
            }
       
        
    }
}
