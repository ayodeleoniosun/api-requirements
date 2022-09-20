<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Support\Enums\CategoryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Domain\Product\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|float|null $discount_value
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Product\Models\Product[] $products
 * @property-read int|null $products_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getDiscountValueAttribute(): float|int|null
    {
        if (! $this->discount) {
            return null;
        }

        return $this->discount / 100;
    }

    public function isDiscountable(): bool
    {
        return in_array($this->name, array_keys(CategoryEnum::DISCOUNTABLE_CATEGORIES));
    }
}
