<?php

namespace App\Domain\Product\Providers;

use App\Domain\Product\Contracts\ProductServiceContract;
use App\Domain\Product\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ProductServiceContract::class,
            ProductService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
