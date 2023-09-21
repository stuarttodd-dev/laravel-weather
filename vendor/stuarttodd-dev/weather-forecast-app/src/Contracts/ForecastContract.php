<?php

namespace StuartToddDev\WeatherForecast\Contracts;

use stdClass;

interface ForecastContract
{
    public function setLon(string $lon): self;
    public function getLon(): string;
    public function setLat(string $lat): self;
    public function getLat(): string;
    public function setApiKey(string $apiKey): self;
    public function getForecast(): ?string;
}
