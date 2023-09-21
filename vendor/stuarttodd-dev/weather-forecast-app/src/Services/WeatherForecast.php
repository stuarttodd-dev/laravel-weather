<?php

namespace StuartToddDev\WeatherForecast\Services;

use GuzzleHttp\Client;
use StuartToddDev\WeatherForecast\Contracts\ForecastContract;
use StuartToddDev\WeatherForecast\Contracts\GeolocationContract;

class WeatherForecast
{
    public function __construct(private string $ipAddress, private string $apiKey, private GeolocationContract $geoLocationAPI, private ForecastContract $forecastAPI)
    {
        $geoLocationData = $this->geoLocationAPI
            ->setIPAddress($this->ipAddress)
            ->getGeoLocation();

        $geoLocationData = json_decode($geoLocationData);

        $this->forecastAPI
            ->setApiKey($this->apiKey)
            ->setLat($geoLocationData->lat)
            ->setLon($geoLocationData->lon);
    }

    public static function create(string $ipAddress, string $apiKey): self
    {
        $geoLocationAPI = GeolocationIPAPI::create(new Client());
        $forecastAPI = OpenWeatherAPI::create(new Client());

        return new self($ipAddress, $apiKey, $geoLocationAPI, $forecastAPI);
    }

    public function getIpAddress(): string
    {
        return $this->geoLocationAPI->getIPAddress();
    }

    public function getGeolocation(): string
    {
        return $this->geoLocationAPI->getGeoLocation();
    }

    public function getForecast(): string
    {
        return $this->forecastAPI->getForecast();
    }

}
