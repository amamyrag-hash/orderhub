<?php

namespace App\Reports;

use App\Models\Product;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\DB;

class TopProductsReport
{
    public function queryBuilder(int $limit = 10): QueryBuilder
    {
        return DB::table('order_items as oi')
            ->join('orders as o', 'o.id', '=', 'oi.order_id')
            ->join('products as p', 'p.id', '=', 'oi.product_id')
            ->where('o.status', 'paid')
            ->whereNull('p.deleted_at')
            ->groupBy('p.id', 'p.name', 'p.sku')
            ->select('p.id', 'p.name', 'p.sku')
            ->selectRaw('SUM(oi.quantity) as total_sold')
            ->selectRaw('SUM(oi.quantity * oi.unit_price) as revenue')
            ->selectRaw('COUNT(DISTINCT o.customer_id) as unique_customers')
            ->orderByDesc('total_sold')
            ->orderBy('p.id')
            ->limit($limit);
    }

    public function eloquent(int $limit = 10): EloquentBuilder
    {
        return Product::query()
            ->join('order_items as oi', 'oi.product_id', '=', 'products.id')
            ->join('orders as o', 'o.id', '=', 'oi.order_id')
            ->where('o.status', 'paid')
            ->groupBy(
            'products.id',
            'products.name',
            'products.sku',
            'products.price')
            ->select('products.id',
            'products.name',
            'products.sku',
            'products.price')
            ->selectRaw('SUM(oi.quantity) as total_sold')
            ->selectRaw('SUM(oi.quantity * oi.unit_price) as revenue')
            ->selectRaw('COUNT(DISTINCT o.customer_id) as unique_customers')
            ->orderByDesc('total_sold')
            ->orderBy('products.id')
            ->limit($limit);
    }
}