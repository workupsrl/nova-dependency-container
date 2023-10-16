<?php

namespace Workup\Nova\DependencyContainer;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\NovaServiceProviderRegistered;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Override ActionController after NovaServiceProvider loaded
        Event::listen(NovaServiceProviderRegistered::class, function () {
            app()->bind(
                \Laravel\Nova\Http\Controllers\ActionController::class,
                \Workup\Nova\DependencyContainer\Http\Controllers\ActionController::class
            );
        });
    }
}
