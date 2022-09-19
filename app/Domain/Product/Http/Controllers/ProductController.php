<?php

namespace App\Domain\Product\Http\Controllers;

use App\Domain\Product\Contracts\ProductServiceContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductServiceContract $productService;

    /**
     * @param ProductServiceContract $productService
     */
    public function __construct(ProductServiceContract $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        return $this->productService->index($request);
    }
}