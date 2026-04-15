<?php

namespace App\Services;

use App\Http\Filters\ProductFilter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    private const CACHE_TTL = 600; // 10 minutos

    public function __construct(private ProductFilter $filter) {}

    public function list(Request $request)
    {
        $key = $this->buildCacheKey($request);

        return Cache::remember($key, self::CACHE_TTL, function () use ($request) {
            $query = Product::query();
            $this->filter->apply($query, $request);

            $perPage = $request->integer('per_page', 15);
            return $query->orderByDesc('id')->paginate($perPage)->withQueryString();
        });
    }

    public function create(array $data): Product
    {
        $product = Product::create($data);
        $this->flushCache();
        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        $this->flushCache();
        return $product->fresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
        $this->flushCache();
    }

    private function buildCacheKey(Request $request): string
    {
        $params = $request->only(['name', 'min_price', 'max_price', 'min_stock', 'max_stock', 'per_page', 'page']);
        ksort($params);
        

        $version = Cache::rememberForever('products:version', fn () => 1);
        
        return 'products:list:v' . $version . ':' . md5(json_encode($params));
    }

    private function flushCache(): void
    {
        Cache::forever(
            'products:version',
            Cache::get('products:version', 1) + 1
        );
    }
}
