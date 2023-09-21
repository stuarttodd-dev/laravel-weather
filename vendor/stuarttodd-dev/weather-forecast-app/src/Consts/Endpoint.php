<?php

namespace StuartToddDev\WeatherForecast\Consts;

class Endpoint
{
    public const GEOLOCATION_IP_API = 'http://ip-api.com/json/{ipAddress}';
    public const OPEN_WEATHER_API = 'https://api.openweathermap.org/data/3.0/onecall?lat={lat}&lon={lon}&appid={apiKey}';
}
