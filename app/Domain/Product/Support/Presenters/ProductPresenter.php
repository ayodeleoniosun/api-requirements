<?php

namespace App\Domain\Product\Support\Presenters;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Support\Enums\CategoryEnum;
use App\Domain\Product\Support\Enums\ProductEnum;
use Laracasts\Presenter\Presenter;

class ProductPresenter extends Presenter
{
    public function priceDetails()
    {
        $product = Product::find($this->id);

        return [
            'original' => $product->amount,
            'final' => $this->getFinalPrice($product),
            'discount_percentage' => $this->getDiscountPercentage($product),
            'currency' => config('app.currency'),
        ];
    }

    private function getFinalPrice(Product $product): int
    {
        $finalPrice = $product->amount;

        if ($product->category->isDiscountable()) {
            $discount = $product->amount * $product->category->discount_value;
            $finalPrice = $product->amount - $discount;
        }

        if ($product->isDiscountable()) {
            $discount = $product->discount_value * $this->amount;
            $finalPrice = $product->amount - $discount;
        }

        return intval($finalPrice);
    }

    private function getDiscountPercentage(Product $product): string|null
    {
        if ($product->isDiscountable()) {
            return ProductEnum::DISCOUNTABLE_PRODUCT_SKUS[$product->sku].'%';
        }

        if ($product->category->isDiscountable()) {
            return CategoryEnum::DISCOUNTABLE_CATEGORIES[$product->category->name].'%';
        }

        return null;
    }
}
