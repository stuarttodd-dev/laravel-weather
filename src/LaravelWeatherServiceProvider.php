<?php

namespace Ecce\LaravelWeather;

use Illuminate\Support\ServiceProvider;

class LaravelWeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-weather', function () {
            return new LaravelWeather();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/config/laravel-weather.php' => config_path('laravel-weather.php'),
        ], 'config');

        // Register routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Register views
        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-weather');
    }
}
