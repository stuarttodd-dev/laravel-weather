<?php

namespace Ecce\LaravelWeather\Http\Controllers;

use Ecce\LaravelWeather\Services\LaravelWeather;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


class WeatherController extends Controller
{
    public function index(Request $request)
    {
        // Fetch weather data using the LaravelWeather facade
        $weatherData = new LaravelWeather();
        $weatherData->getCurrentWeather();

        // You can customize the logic here to display weather information as needed
        return view('weather-forecast', ['weatherData' => $weatherData]);
    }
}
