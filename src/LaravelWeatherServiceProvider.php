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

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../views' => resource_path('views/vendor/ecce-laravel-weather'),
            ], 'your-package-namespace-views');
        }

        // Register views
        $this->loadViewsFrom(__DIR__ . '/views', 'ecce-laravel-weather');
    }
}
