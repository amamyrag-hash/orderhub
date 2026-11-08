<?php

namespace App\Enums;

enum OrderStatus : string
{
    case Draft = "draft";
    case Invoiced = 'invoiced';
    case Pending = "pending";
    case Paid ="paid";
    case Shipped = "shipped";
    case Delivered = "delivered";
    case Canceled = "canceled";

    public function lable(): string
    {
        return match ($this){
            self::Pending =>'در انتظار برداخت',
            self::Paid => 'ئرداخت شد',
            self::Shipped => "ارسال شد",
            self::Delivered => "تحویل شد",
            self::Canceled => "لغو شد",
        };
    }
}
