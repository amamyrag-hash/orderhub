<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required' , 'string' , 'max:255'],
            'sku'=>['required' , 'string', 'max:50' , Rule::unique('products' , 'sku')->ignore($this->route('product'))],
            'description'=>['nullable', 'string'],
            'price'=>['required' , 'numeric'  , 'min:0' , 'decimal:0,2' , 'max:99999999.99'],
            'stock'=>['nullable' , 'integer' , 'min:0' , 'max:32767']
        ];
    }
     public function messages(): array
    {
        return [
            'sku.unique'=> 'این محصول قبلا ثبت شده است SKU',
            'sku.required'=> 'الزامی است SKU وارد کردن',
            'name.required'=>'نام محصول الزامی است',
            'price.required'=>'قیمت الزامی است',
            'price.integer'=>'قیمت باید عدد صحیح باشد',
            'stock.integer'=>'تعدا باید عدد باشد'
        ];
    }
    
}
