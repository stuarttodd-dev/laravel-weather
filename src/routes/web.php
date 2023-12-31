<?php

use Illuminate\Support\Facades\Route;
use Ecce\LaravelWeather\Http\Controllers\WeatherController;

Route::get('/weather-forecasts', [WeatherController::class, 'index'])->name('weather.index');
Route::post('/weather-forecasts', [WeatherController::class, 'fetch'])->name('weather.fetch');