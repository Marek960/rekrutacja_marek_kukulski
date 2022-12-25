<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Filters\ProductNameService;
use App\Services\Filters\ProductDescriptionService;
use App\Services\Filters\ProductPriceService;
use App\Services\Filters\FilterInterface;
use App\Services\Filters\SortNameService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->tag(
            [
                ProductNameService::class,
                ProductDescriptionService::class,
                ProductPriceService::class,
                SortNameService::class
            ],
            FilterInterface::class
        );
    }
}
