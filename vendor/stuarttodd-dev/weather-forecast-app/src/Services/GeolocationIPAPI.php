<?php

namespace StuartToddDev\WeatherForecast\Services;

use InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use StuartToddDev\WeatherForecast\Consts\Endpoint;
use StuartToddDev\WeatherForecast\Contracts\GeolocationContract;

use stdClass;

class GeolocationIPAPI implements GeolocationContract
{
    private string $ipAddress;

    public function __construct(private Client $httpClient, private string $url)
    {

    }

    public static function create(Client $httpClient, ?string $url = null): self
    {
        return new self($httpClient, $url ?? Endpoint::GEOLOCATION_IP_API);
    }

    public function setIPAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getIPAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function getGeoLocation(): ?string
    {
        if (!filter_var($this->ipAddress, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Invalid IP address: ' . $this->ipAddress);
        }

        $placeholders = [
            '{ipAddress}' => $this->ipAddress ?? '',
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
