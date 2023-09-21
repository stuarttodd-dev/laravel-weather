<?php

namespace StuartToddDev\WeatherForecast\Contracts;

interface GeolocationContract
{
    public function setIPAddress(string $ipAddress): self;
    public function getIPAddress(): ?string;
    public function getGeoLocation(): ?string;
}
