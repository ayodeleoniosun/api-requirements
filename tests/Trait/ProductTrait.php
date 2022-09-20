<?php

namespace Tests\Trait;

trait ProductTrait
{
    public function getDiscountedProducts(array $products, bool $status = true): array
    {
        return array_values(array_filter($products, function ($product) use ($status) {
            return !$status ? empty($product->price->discount_percentage) : !empty($product->price->discount_percentage);
        }));
    }
}