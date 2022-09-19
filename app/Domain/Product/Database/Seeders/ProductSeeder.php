<?php

namespace App\Domain\Product\Database\Seeders;

use App\Domain\Product\Models\Category;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Support\Enums\Category as CategoryEnum;
use App\Exceptions\CustomException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws CustomException
     */
    public function run(): void
    {
        $products = $this->getProducts();

        foreach ($products as $product) {
            $productCategory = $product['category'];

            $category = Category::whereName($productCategory)->first();

            if (!$category) {
                $category = Category::create([
                    'name' => $productCategory,
                    'slug' => Str::snake($productCategory),
                    'discount' => $productCategory === CategoryEnum::DISCOUNTABLE ? 30 : null
                ]);
            }

            Product::create([
                'category_id' => $category->id,
                'name' => $product['name'],
                'price' => $product['price'],
                'sku' => $product['sku'],
            ]);
        }
    }

    /**
     * @throws CustomException
     */
    private function getProducts()
    {
        $file = resource_path() . '/json/products.json';

        if (!File::exists($file)) {
            throw new CustomException('Product dataset not found', 404);
        }

        return json_decode(file_get_contents($file), true)['products'];
    }
}
