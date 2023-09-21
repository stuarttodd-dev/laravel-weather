<?php

namespace Ecce\LaravelWeather\Tests\Feature;

use Ecce\LaravelWeather\Services\LaravelWeather;
use PHPUnit\Framework\TestCase;

class PackageRoutesTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testWeatherForecastRoute()
    {
        $weatherData = new LaravelWeather();
        $weatherData->getCurrentWeather('1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

}
