<?php

namespace Feature\Product;

use App\Domain\Product\Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Trait\ProductTrait;

uses(RefreshDatabase::class, ProductTrait::class);

beforeEach(function () {
    $this->seed(ProductSeeder::class);
});

test('get all products with no filter', function () {
    $response = $this->getJson($this->baseUrl . '/products');
    $products = json_decode($response->content())->data->products;

    $this->assertEquals(5, count($products));

    $response->assertJsonStructure([
        'data' => [
            'products' => [
                '*' => ['id', 'sku', 'name', 'category', 'price' => [
                    'original', 'final', 'discount_percentage', 'currency'
                ], 'created_at', 'updated_at']
            ]
        ]
    ]);
});

test('get all products that has discounts', function () {
    $response = $this->getJson($this->baseUrl . '/products');
    $products = json_decode($response->content())->data->products;
    $discountedProducts = $this->getDiscountedProducts($products);

    foreach ($discountedProducts as $product) {
        expect($product->price->original)->toBeGreaterThan($product->price->final);
        expect($product->price->discount_percentage)->toBeString();
        expect($product->price->discount_percentage)->toContain('%');
    }
});

test('get all products that has no discounts', function () {
    $response = $this->getJson($this->baseUrl . '/products');
    $products = json_decode($response->content())->data->products;
    $discountedProducts = $this->getDiscountedProducts($products, false);

    foreach ($discountedProducts as $product) {
        expect($product->price->original)->toEqual($product->price->final);
        expect($product->price->discount_percentage)->toBeNull();
    }
});

test('filter all products by category', function () {
    $category = 'insurance';

    $response = $this->getJson($this->baseUrl . '/products?category=' . $category);
    $products = json_decode($response->content())->data->products;

    foreach ($products as $product) {
        expect($product->category)->toEqual($category);
    }
});

test('filter all products by price range', function () {
    $fromPrice = 80000;
    $toPrice = 180000;

    $response = $this->getJson($this->baseUrl . '/products?price[from]=' . $fromPrice . '&price[to]=' . $toPrice);
    $products = json_decode($response->content())->data->products;

    foreach ($products as $product) {
        expect($product->price->original)->toBeGreaterThanOrEqual($fromPrice);
        expect($product->price->original)->toBeLessThanOrEqual($toPrice);
    }
});

test('filter all products by both category and price range', function () {
    $category = 'vehicle';
    $fromPrice = 80000;
    $toPrice = 180000;

    $response = $this->getJson($this->baseUrl . '/products?category=' . $category . '&price[from]=' . $fromPrice . '&price[to]=' . $toPrice);
    $products = json_decode($response->content())->data->products;

    foreach ($products as $product) {
        expect($product->category)->toEqual($category);
        expect($product->price->original)->toBeGreaterThanOrEqual($fromPrice);
        expect($product->price->original)->toBeLessThanOrEqual($toPrice);
    }
});