<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Models\Builders\ProductBuilder;
use App\Domain\Product\Support\Enums\ProductEnum;
use App\Domain\Product\Support\Presenters\ProductPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;

/**
 * App\Domain\Product\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property int $price
 * @property string $sku
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Product\Models\Category $category
 * @property-read int|float $amount
 * @property-read int|float|null $discount_value
 *
 * @method static ProductBuilder|Product filterByCategory(string $category)
 * @method static ProductBuilder|Product filterByPrice(array $price)
 * @method static ProductBuilder|Product newModelQuery()
 * @method static ProductBuilder|Product newQuery()
 * @method static ProductBuilder|Product query()
 * @method static ProductBuilder|Product whereCategoryId($value)
 * @method static ProductBuilder|Product whereCreatedAt($value)
 * @method static ProductBuilder|Product whereId($value)
 * @method static ProductBuilder|Product whereName($value)
 * @method static ProductBuilder|Product wherePrice($value)
 * @method static ProductBuilder|Product whereSku($value)
 * @method static ProductBuilder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        if (! $this->isDiscountable()) {
            return null;
        }

        return ProductEnum::DISCOUNTABLE_PRODUCT_SKUS[$this->sku] / 100;
    }

    public function isDiscountable(): bool
    {
        return in_array($this->sku, array_keys(ProductEnum::DISCOUNTABLE_PRODUCT_SKUS));
    }
}
