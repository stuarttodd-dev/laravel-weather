# Laravel Weather Package

The Laravel Weather Package is a powerful tool for integrating weather forecast data into your Laravel application. It allows you to fetch weather data for a given IP address, display geo-location information, and present a 5-day weather forecast along with a map for visualization.

## Installation

To get started with the Laravel Weather Package, follow these steps:

1. Configure composer.json
```
"minimum-stability": "dev",
```

2. Install the package via Composer:
```bash
composer require ecce/laravel-weather
```
3. Publish the package configuration and views:
```
php artisan vendor:publish --tag=laravel-weather-config
php artisan vendor:publish --tag=laravel-weather-assets
php artisan vendor:publish --tag=laravel-weather-views
```

4. Configure your API key in the config/laravel-weather.php file.
Visit - https://openweathermap.org/api
```
return [
    'api_key' => env('OPEN_WEATHER_API_KEY', ''),
];
```
5. Fetch data option
```
use Ecce\LaravelWeather\Facades\LaravelWeather;

// Example: Fetch weather data for an IP address
$ipAddress = '123.45.67.89';
$weatherData = LaravelWeather::getDailyForecast($ipAddress);

// Check for errors
if (isset($weatherData['error'])) {
    // Handle the error
    $error = $weatherData['error'];
    // ...
} else {
    // Display weather information
    $geoLocation = $weatherData['geoLocation'];
    $forecast = $weatherData['forecast'];
    // ...
}
```
6. Visit URL
Visit **/weather-forecasts** within your Laravel app
