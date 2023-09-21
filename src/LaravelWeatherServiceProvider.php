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
        $this->loadViewsFrom(__DIR__.'/views', 'ecce-laravel-weather');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/ecce-laravel-weather'),
        ], 'views');

        $this->publishes([
            __DIR__.'/public/weather-icons' => public_path('vendor/ecce-laravel-weather'),
        ], 'public');
    }
}
