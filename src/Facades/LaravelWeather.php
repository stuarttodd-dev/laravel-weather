<?php

namespace Ecce\LaravelWeather\Facades;

use StuartToddDev\WeatherForecast\Services\WeatherForecast;

class LaravelWeather
{
    public static function getDailyForecast(string $ipAddress): array
    {
        $weatherForecast = WeatherForecast::create($ipAddress, config('laravel-weather.api_key'));

        return [
            'ipAddress' => $ipAddress,
            'geoLocation' => json_decode($weatherForecast->getGeolocation()),
            'forecast' => json_decode($weatherForecast->getForecast()),
        ];
    }
}
