<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Models\Builders\CategoryBuilder;
use App\Domain\Product\Support\Enums\CategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function newEloquentBuilder($query): CategoryBuilder
    {
        return new CategoryBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getDiscountValueAttribute(): float|int|null
    {
        if (!$this->discount) {
            return null;
        }

        return $this->discount / 100;
    }

    public function isDiscountable(): bool
    {
        return in_array($this->name, array_keys(CategoryEnum::DISCOUNTABLE_CATEGORIES));
    }

}
