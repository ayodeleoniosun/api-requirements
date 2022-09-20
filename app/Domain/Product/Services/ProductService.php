<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\Contracts\ProductServiceContract;
use App\Domain\Product\Http\Resources\ProductCollection;
use App\Domain\Product\Models\Product;
use Illuminate\Http\Request;

class ProductService implements ProductServiceContract
{
    public function index(Request $request): ProductCollection
    {
        $category = $request->input('category');
        $price = $request->input('price');

        $products = Product::query()
            ->when($category, function ($query, $category) {
                $query->filterByCategory($category);
            })->when($price, function ($query, $price) {
                $query->filterByPrice($price);
            }, function ($query) {
                $query->latest('products.created_at');
            })->get();

        return new ProductCollection($products);
    }
}
