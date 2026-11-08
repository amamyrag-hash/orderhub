<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id' , 'status' , 'total_amount' , 'invoice_date'] ;
    public function customer() 
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function casts(): array
    {
        return[
            'status'=>OrderStatus::class,
            'invoice_date'=>'datetime'
        ];

    }

    protected static function booted(): void
    {
        static::updating(function(Order $order){
            if(
                $order->isDirty('status')
                && $order->getOriginal('status')=== OrderStatus::Draft
                && $order->status===OrderStatus::Invoiced
                && $order->invoice_date ===null
            ){
                $order->invoice_date=now();
            }
        });
    }
}

