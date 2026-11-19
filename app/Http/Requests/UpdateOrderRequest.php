<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use App\Rules\ProductCount;
use App\Rules\ProductFinde;
use App\Rules\SufficientStock;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status'=>['requird' , Rule::enum(OrderStatus::class)],
            "items"=> ['required', 'array','min:1'],
            'items.*.product_id' => ['required','integer','distinct', new ProductFinde()],
            'items.*.quantity'=> ['required','integer','min:1', new ProductCount()],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required'=> 'وضعیت سفارش نباید خالی باشه',
            "items.required" => 'سفارش باید حداقل یک آیتم داشته باشد',
            "items.array"=>'فرمت آیتم های سفارش معتبر نیست',
            'items.min'=>'حداقل یدونه آیتم داشته باشد',

            'items.*.product_id.required'=>'شناسه محصول الزامی است',
            'items.*.product_id.integer'=>'آیدی محصول باید عدد باشد',
            'items.*.product_id.distinct'=>'آیدی هر محصول باید در یک آیتم باشد',
            'items.*.quantity.required'=>'تعداد ایتم ها نباید خالی باشد',
            'items.*.quantity.integer'=>'تعداد ایتم ها باید عدد باشد',
            'items.*.quantity.min'=>'تعداد آیتم ها نمیتواند کمتر از یک باشد',
        ];
    }

   
}
