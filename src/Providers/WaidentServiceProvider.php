<?php

namespace Mohdradzee\Waident\Providers;

use Illuminate\Support\ServiceProvider;

class WaidentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'waident');
        $this->publishes([
            __DIR__.'/../config/waident.php' => config_path('waident.php'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/waident.php', 'waident'
        );
    }
}