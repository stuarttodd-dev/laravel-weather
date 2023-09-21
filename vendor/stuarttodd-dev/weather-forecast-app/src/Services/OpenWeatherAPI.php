<?php

namespace StuartToddDev\WeatherForecast\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use StuartToddDev\WeatherForecast\Consts\Endpoint;
use StuartToddDev\WeatherForecast\Contracts\ForecastContract;
use stdClass;

class OpenWeatherAPI implements ForecastContract
{
    private ?string $lon = null;
    private ?string $lat = null;
    private ?string $part = null;
    private ?string $apiKey = null;

    public function __construct(private Client $httpClient, private string $url)
    {

    }

    public static function create(Client $httpClient, ?string $url = null): self
    {
        return new self($httpClient, $url ?? Endpoint::OPEN_WEATHER_API);
    }

    public function setLon(string $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getLon(): string
    {
        return $this->lon;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLat(): string
    {
        return $this->lat;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getForecast(): ?string
    {
        $placeholders = [
            '{lon}' => $this->lon ?? '',
            '{lat}' => $this->lat ?? '',
            '{part}' => $this->part ?? '',
            '{apiKey}' => $this->apiKey ?? '',
        ];

        $this->url = str_replace(array_keys($placeholders), array_values($placeholders), $this->url);

        try {
            $response = $this->httpClient->get($this->url);

            return $response->getBody()->getContents();

        } catch (RequestException $e) {
            return null;
        }
    }

}
