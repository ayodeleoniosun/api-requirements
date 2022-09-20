<?php

namespace App\Domain\Product\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'products' => $this->collection,
        ];
    }
}
