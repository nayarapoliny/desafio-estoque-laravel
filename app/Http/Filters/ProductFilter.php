<?php
namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilter
{
    public function apply(Builder $query, Request $request): Builder
    {
        return $query
            ->when($request->filled('name'), fn ($q) =>
                $q->where('name', 'like', '%' . $request->string('name') . '%'))
            ->when($request->filled('min_price'), fn ($q) =>
                $q->where('price', '>=', $request->float('min_price')))
            ->when($request->filled('max_price'), fn ($q) =>
                $q->where('price', '<=', $request->float('max_price')))
            ->when($request->filled('min_stock'), fn ($q) =>
                $q->where('stock', '>=', $request->integer('min_stock')))
            ->when($request->filled('max_stock'), fn ($q) =>
                $q->where('stock', '<=', $request->integer('max_stock')));
    }
}