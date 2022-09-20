<?php

namespace App\Domain\Product\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ProductBuilder extends Builder
{
    public function filterByCategory(string $category): self
    {
        return $this->where('categories.name', $category)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.name as name',
                'categories.name as category_name',
                'products.*',
            );
    }

    public function filterByPrice(array $price): self
    {
        $fromPrice = $this->setPrice($price['from']);
        $toPrice = $this->setPrice($price['to']);

        return $this->whereBetween('price', [$fromPrice, $toPrice]);
    }

    private function setPrice(int $price): int
    {
        return $price * 100;
    }
}
