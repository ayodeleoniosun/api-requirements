<?php

namespace App\Domain\Product\Contracts;

use Illuminate\Http\Request;

interface ProductServiceContract
{
    public function index(Request $request);
}