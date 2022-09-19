<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\Contracts\ProductServiceContract;
use App\Domain\Product\Http\Resources\ProductCollection;
use App\Domain\Product\Models\Product;
use Illuminate\Http\Request;

class ProductService implements ProductServiceContract
{
    public function index(Request $request)
    {
        return new ProductCollection(Product::all());
    }

}