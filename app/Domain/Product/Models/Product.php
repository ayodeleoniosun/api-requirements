<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Models\Builders\ProductBuilder;
use App\Domain\Product\Support\Enums\ProductEnum;
use App\Domain\Product\Support\Presenters\ProductPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;

class Product extends Model
{
    use HasFactory, PresentableTrait;

    protected $guarded = ['id'];

    protected string $presenter = ProductPresenter::class;

    public function newEloquentBuilder($query): ProductBuilder
    {
        return new ProductBuilder($query);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getAmountAttribute(): float|int
    {
        return $this->price / 100;
    }

    public function setPriceAttribute(int $price): float|int
    {
        return $this->attributes['price'] = $price * 100;
    }

    public function getDiscountValueAttribute(): float|int|null
    {
        if (!$this->isDiscountable()) {
            return null;
        }

        return ProductEnum::DISCOUNTABLE_PRODUCT_SKUS[$this->sku] / 100;
    }

    public function isDiscountable(): bool
    {
        return in_array($this->sku, array_keys(ProductEnum::DISCOUNTABLE_PRODUCT_SKUS));
    }

}
