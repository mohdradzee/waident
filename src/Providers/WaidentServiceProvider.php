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
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'waident');
    }
    
}