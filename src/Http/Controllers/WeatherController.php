<?php

namespace Ecce\LaravelWeather\Http\Controllers;

use Ecce\LaravelWeather\Facades\LaravelWeather;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        return view('ecce-laravel-weather::weather-forecast');
    }

    public function fetch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ip' => 'required|ip',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ip = $request->input('ip');

        $weatherData = Cache::remember('weather_data_' . $ip, now()->addHour(), function () use ($ip) {
            // If the data is not found in the cache, fetch it from your source
            return LaravelWeather::getDailyForecast($ip);
        });

        if ($weatherData === null) {
            return back()->with('error', 'Invalid IP address.');
        }

        return view('ecce-laravel-weather::weather-forecast', ['weatherData' => $weatherData]);
    }

}
