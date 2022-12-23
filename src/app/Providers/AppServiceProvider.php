<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Filters\ProductNameService;
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
                SortNameService::class
            ],
            FilterInterface::class
        );
    }
}
