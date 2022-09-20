<?php

namespace App\Domain\Product\Contracts;

use App\Domain\Product\Http\Resources\ProductCollection;
use Illuminate\Http\Request;

interface ProductServiceContract
{
    public function index(Request $request): ProductCollection;
}
