<?php

use Illuminate\Support\Facades\Route;
use Ecce\LaravelWeather\Controllers\WeatherController;

Route::get('/weather-forecasts', [WeatherController::class, 'index'])->name('weather.index');
