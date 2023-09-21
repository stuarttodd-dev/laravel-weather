<?php

namespace StuartToddDev\WeatherForecast\Tests;

use PHPUnit\Framework\TestCase;

use StuartToddDev\WeatherForecast\Contracts\ForecastContract;
use StuartToddDev\WeatherForecast\Contracts\GeolocationContract;

use StuartToddDev\WeatherForecast\Services\GeolocationIPAPI;
use StuartToddDev\WeatherForecast\Services\OpenWeatherAPI;
use StuartToddDev\WeatherForecast\Services\WeatherForecast;

use GuzzleHttp\Client;
use InvalidArgumentException;

class WeatherForecastTest extends TestCase
{
    private string $genericIpAddress = '86.22.157.53';

    private GeolocationContract $geolocationAPI;
    private ForecastContract $forecastAPI;

    private string $responseJsonGeo;
    private string $responseJsonForecast;

    protected function setUp(): void
    {
        $this->geolocationAPI = $this->createMock(GeolocationIPAPI::class);
        $this->responseJsonGeo = '{"lat": 37.7749, "lon": -122.4194, "countryCode": "US", "regionName": "San Francisco"}';

        $this->forecastAPI = $this->createMock(OpenWeatherAPI::class);
        $this->responseJsonForecast = '{"lat":37.7749,"lon":-122.4194,"timezone":"America/Los_Angeles","timezone_offset":-25200,"current":{"dt":1695241994,"sunrise":1695218138,"sunset":1695262246,"temp":293,"feels_like":292.92,"pressure":1010,"humidity":72,"dew_point":287.81,"uvi":5.78,"clouds":20,"visibility":10000,"wind_speed":6.26,"wind_deg":277,"wind_gust":8.05,"weather":[{"id":711,"main":"Smoke","description":"smoke","icon":"50d"}]},"minutely":[{"dt":1695242040,"precipitation":0},{"dt":1695242100,"precipitation":0},{"dt":1695242160,"precipitation":0},{"dt":1695242220,"precipitation":0},{"dt":1695242280,"precipitation":0},{"dt":1695242340,"precipitation":0},{"dt":1695242400,"precipitation":0},{"dt":1695242460,"precipitation":0},{"dt":1695242520,"precipitation":0},{"dt":1695242580,"precipitation":0},{"dt":1695242640,"precipitation":0},{"dt":1695242700,"precipitation":0},{"dt":1695242760,"precipitation":0},{"dt":1695242820,"precipitation":0},{"dt":1695242880,"precipitation":0},{"dt":1695242940,"precipitation":0},{"dt":1695243000,"precipitation":0},{"dt":1695243060,"precipitation":0},{"dt":1695243120,"precipitation":0},{"dt":1695243180,"precipitation":0},{"dt":1695243240,"precipitation":0},{"dt":1695243300,"precipitation":0},{"dt":1695243360,"precipitation":0},{"dt":1695243420,"precipitation":0},{"dt":1695243480,"precipitation":0},{"dt":1695243540,"precipitation":0},{"dt":1695243600,"precipitation":0},{"dt":1695243660,"precipitation":0},{"dt":1695243720,"precipitation":0},{"dt":1695243780,"precipitation":0},{"dt":1695243840,"precipitation":0},{"dt":1695243900,"precipitation":0},{"dt":1695243960,"precipitation":0},{"dt":1695244020,"precipitation":0},{"dt":1695244080,"precipitation":0},{"dt":1695244140,"precipitation":0},{"dt":1695244200,"precipitation":0},{"dt":1695244260,"precipitation":0},{"dt":1695244320,"precipitation":0},{"dt":1695244380,"precipitation":0},{"dt":1695244440,"precipitation":0},{"dt":1695244500,"precipitation":0},{"dt":1695244560,"precipitation":0},{"dt":1695244620,"precipitation":0},{"dt":1695244680,"precipitation":0},{"dt":1695244740,"precipitation":0},{"dt":1695244800,"precipitation":0},{"dt":1695244860,"precipitation":0},{"dt":1695244920,"precipitation":0},{"dt":1695244980,"precipitation":0},{"dt":1695245040,"precipitation":0},{"dt":1695245100,"precipitation":0},{"dt":1695245160,"precipitation":0},{"dt":1695245220,"precipitation":0},{"dt":1695245280,"precipitation":0},{"dt":1695245340,"precipitation":0},{"dt":1695245400,"precipitation":0},{"dt":1695245460,"precipitation":0},{"dt":1695245520,"precipitation":0},{"dt":1695245580,"precipitation":0},{"dt":1695245640,"precipitation":0}],"hourly":[{"dt":1695240000,"temp":292.73,"feels_like":292.6,"pressure":1010,"humidity":71,"dew_point":287.33,"uvi":6.12,"clouds":16,"visibility":10000,"wind_speed":5.58,"wind_deg":203,"wind_gust":5.31,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695243600,"temp":293,"feels_like":292.92,"pressure":1010,"humidity":72,"dew_point":287.81,"uvi":5.78,"clouds":20,"visibility":10000,"wind_speed":6.57,"wind_deg":208,"wind_gust":6.51,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695247200,"temp":292.75,"feels_like":292.59,"pressure":1010,"humidity":70,"dew_point":287.13,"uvi":4.58,"clouds":16,"visibility":10000,"wind_speed":6.94,"wind_deg":213,"wind_gust":6.81,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695250800,"temp":292.48,"feels_like":292.27,"pressure":1009,"humidity":69,"dew_point":286.65,"uvi":2.9,"clouds":12,"visibility":10000,"wind_speed":6.18,"wind_deg":216,"wind_gust":6.1,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695254400,"temp":292.03,"feels_like":291.75,"pressure":1009,"humidity":68,"dew_point":286,"uvi":1.34,"clouds":8,"visibility":10000,"wind_speed":5.27,"wind_deg":216,"wind_gust":5.11,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695258000,"temp":290.82,"feels_like":290.47,"pressure":1008,"humidity":70,"dew_point":285.29,"uvi":0.41,"clouds":4,"visibility":10000,"wind_speed":4.69,"wind_deg":218,"wind_gust":4.41,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695261600,"temp":288.3,"feels_like":287.93,"pressure":1008,"humidity":79,"dew_point":284.45,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4.68,"wind_deg":210,"wind_gust":4.51,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695265200,"temp":286.89,"feels_like":286.54,"pressure":1008,"humidity":85,"dew_point":284.19,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4.5,"wind_deg":215,"wind_gust":4.2,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695268800,"temp":286.35,"feels_like":286,"pressure":1008,"humidity":87,"dew_point":284,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4.63,"wind_deg":210,"wind_gust":4.82,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695272400,"temp":286.34,"feels_like":285.99,"pressure":1008,"humidity":87,"dew_point":283.96,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.98,"wind_deg":208,"wind_gust":4.22,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695276000,"temp":286.44,"feels_like":286.07,"pressure":1008,"humidity":86,"dew_point":283.98,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.32,"wind_deg":198,"wind_gust":3.91,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695279600,"temp":286.54,"feels_like":286.18,"pressure":1008,"humidity":86,"dew_point":284.07,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4,"wind_deg":195,"wind_gust":4.52,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695283200,"temp":286.68,"feels_like":286.36,"pressure":1008,"humidity":87,"dew_point":284.22,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4.19,"wind_deg":193,"wind_gust":4.64,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695286800,"temp":286.89,"feels_like":286.57,"pressure":1009,"humidity":86,"dew_point":284.4,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4.33,"wind_deg":186,"wind_gust":4.8,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695290400,"temp":287.11,"feels_like":286.81,"pressure":1009,"humidity":86,"dew_point":284.51,"uvi":0,"clouds":7,"visibility":10000,"wind_speed":4.7,"wind_deg":177,"wind_gust":5.54,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695294000,"temp":287.15,"feels_like":286.83,"pressure":1009,"humidity":85,"dew_point":284.34,"uvi":0,"clouds":6,"visibility":10000,"wind_speed":3.83,"wind_deg":176,"wind_gust":4.52,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695297600,"temp":286.87,"feels_like":286.52,"pressure":1009,"humidity":85,"dew_point":284.06,"uvi":0,"clouds":5,"visibility":10000,"wind_speed":2.91,"wind_deg":164,"wind_gust":3.12,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695301200,"temp":286.83,"feels_like":286.42,"pressure":1010,"humidity":83,"dew_point":283.83,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":2.66,"wind_deg":154,"wind_gust":3.01,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695304800,"temp":286.91,"feels_like":286.51,"pressure":1010,"humidity":83,"dew_point":283.76,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.03,"wind_deg":157,"wind_gust":3.34,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695308400,"temp":287.5,"feels_like":287.08,"pressure":1011,"humidity":80,"dew_point":283.9,"uvi":0.23,"clouds":0,"visibility":10000,"wind_speed":3.21,"wind_deg":168,"wind_gust":3.71,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695312000,"temp":288.31,"feels_like":287.87,"pressure":1012,"humidity":76,"dew_point":283.77,"uvi":0.96,"clouds":0,"visibility":10000,"wind_speed":3.02,"wind_deg":174,"wind_gust":3.31,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695315600,"temp":289.24,"feels_like":288.73,"pressure":1012,"humidity":70,"dew_point":283.41,"uvi":2.31,"clouds":0,"visibility":10000,"wind_speed":3.03,"wind_deg":173,"wind_gust":2.8,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695319200,"temp":290.08,"feels_like":289.53,"pressure":1012,"humidity":65,"dew_point":282.79,"uvi":3.97,"clouds":0,"visibility":10000,"wind_speed":2.85,"wind_deg":168,"wind_gust":2.51,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695322800,"temp":290.84,"feels_like":290.28,"pressure":1012,"humidity":62,"dew_point":282.21,"uvi":5.49,"clouds":0,"visibility":10000,"wind_speed":2.62,"wind_deg":163,"wind_gust":2.4,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695326400,"temp":291.65,"feels_like":291.12,"pressure":1011,"humidity":60,"dew_point":282.77,"uvi":6.17,"clouds":0,"visibility":10000,"wind_speed":3.36,"wind_deg":175,"wind_gust":3.43,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695330000,"temp":292.44,"feels_like":292.02,"pressure":1011,"humidity":61,"dew_point":283.72,"uvi":5.82,"clouds":0,"visibility":10000,"wind_speed":4.3,"wind_deg":196,"wind_gust":4.52,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695333600,"temp":292.89,"feels_like":292.51,"pressure":1010,"humidity":61,"dew_point":284.43,"uvi":4.62,"clouds":0,"visibility":10000,"wind_speed":5.39,"wind_deg":215,"wind_gust":5.72,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695337200,"temp":292.38,"feels_like":291.98,"pressure":1010,"humidity":62,"dew_point":284.42,"uvi":2.91,"clouds":0,"visibility":10000,"wind_speed":5.84,"wind_deg":219,"wind_gust":6.31,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695340800,"temp":291.89,"feels_like":291.46,"pressure":1010,"humidity":63,"dew_point":284.17,"uvi":1.34,"clouds":0,"visibility":10000,"wind_speed":4.98,"wind_deg":225,"wind_gust":5.4,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695344400,"temp":291.1,"feels_like":290.67,"pressure":1010,"humidity":66,"dew_point":284.33,"uvi":0.41,"clouds":0,"visibility":10000,"wind_speed":4.34,"wind_deg":224,"wind_gust":4.61,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695348000,"temp":289.36,"feels_like":289.02,"pressure":1011,"humidity":76,"dew_point":284.86,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4.45,"wind_deg":226,"wind_gust":4.5,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695351600,"temp":287.7,"feels_like":287.43,"pressure":1011,"humidity":85,"dew_point":284.91,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":4.35,"wind_deg":231,"wind_gust":4.41,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695355200,"temp":287.11,"feels_like":286.83,"pressure":1012,"humidity":87,"dew_point":284.69,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.94,"wind_deg":230,"wind_gust":4.11,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695358800,"temp":286.88,"feels_like":286.58,"pressure":1012,"humidity":87,"dew_point":284.47,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.96,"wind_deg":228,"wind_gust":4.4,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695362400,"temp":286.69,"feels_like":286.37,"pressure":1013,"humidity":87,"dew_point":284.19,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.7,"wind_deg":233,"wind_gust":4.3,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695366000,"temp":286.49,"feels_like":286.15,"pressure":1013,"humidity":87,"dew_point":284.03,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.46,"wind_deg":234,"wind_gust":4.02,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695369600,"temp":286.28,"feels_like":285.92,"pressure":1013,"humidity":87,"dew_point":283.87,"uvi":0,"clouds":0,"visibility":10000,"wind_speed":3.5,"wind_deg":229,"wind_gust":3.92,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695373200,"temp":286.08,"feels_like":285.7,"pressure":1013,"humidity":87,"dew_point":283.77,"uvi":0,"clouds":1,"visibility":10000,"wind_speed":3.32,"wind_deg":225,"wind_gust":3.72,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695376800,"temp":285.91,"feels_like":285.51,"pressure":1013,"humidity":87,"dew_point":283.65,"uvi":0,"clouds":2,"visibility":10000,"wind_speed":3.03,"wind_deg":228,"wind_gust":3.3,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695380400,"temp":285.72,"feels_like":285.33,"pressure":1014,"humidity":88,"dew_point":283.55,"uvi":0,"clouds":3,"visibility":10000,"wind_speed":2.47,"wind_deg":232,"wind_gust":2.61,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695384000,"temp":285.59,"feels_like":285.21,"pressure":1014,"humidity":89,"dew_point":283.56,"uvi":0,"clouds":3,"visibility":10000,"wind_speed":2.29,"wind_deg":231,"wind_gust":2.52,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01n"}],"pop":0},{"dt":1695387600,"temp":285.49,"feels_like":285.1,"pressure":1014,"humidity":89,"dew_point":283.53,"uvi":0,"clouds":11,"visibility":10000,"wind_speed":1.74,"wind_deg":236,"wind_gust":2.24,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02n"}],"pop":0},{"dt":1695391200,"temp":285.81,"feels_like":285.43,"pressure":1015,"humidity":88,"dew_point":283.62,"uvi":0,"clouds":13,"visibility":10000,"wind_speed":1.63,"wind_deg":215,"wind_gust":2.4,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695394800,"temp":286.57,"feels_like":286.19,"pressure":1015,"humidity":85,"dew_point":283.79,"uvi":0.21,"clouds":14,"visibility":10000,"wind_speed":1.17,"wind_deg":216,"wind_gust":2.2,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695398400,"temp":287.79,"feels_like":287.37,"pressure":1016,"humidity":79,"dew_point":283.94,"uvi":0.96,"clouds":14,"visibility":10000,"wind_speed":1.17,"wind_deg":184,"wind_gust":2.3,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695402000,"temp":288.95,"feels_like":288.49,"pressure":1016,"humidity":73,"dew_point":283.83,"uvi":2.32,"clouds":12,"visibility":10000,"wind_speed":1.89,"wind_deg":173,"wind_gust":2.31,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"pop":0},{"dt":1695405600,"temp":289.89,"feels_like":289.45,"pressure":1016,"humidity":70,"dew_point":283.82,"uvi":4.01,"clouds":10,"visibility":10000,"wind_speed":2.94,"wind_deg":175,"wind_gust":3,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0},{"dt":1695409200,"temp":290.37,"feels_like":289.95,"pressure":1016,"humidity":69,"dew_point":283.87,"uvi":5.55,"clouds":0,"visibility":10000,"wind_speed":3.58,"wind_deg":185,"wind_gust":3.51,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"pop":0}],"daily":[{"dt":1695240000,"sunrise":1695218138,"sunset":1695262246,"moonrise":1695238440,"moonset":1695272820,"moon_phase":0.18,"summary":"You can expect partly cloudy in the morning, with clearing in the afternoon","temp":{"day":292.73,"min":286.34,"max":293,"night":286.44,"eve":288.3,"morn":286.88},"feels_like":{"day":292.6,"night":286.07,"eve":287.93,"morn":286.63},"pressure":1010,"humidity":71,"dew_point":287.33,"wind_speed":6.94,"wind_deg":213,"wind_gust":6.81,"weather":[{"id":801,"main":"Clouds","description":"few clouds","icon":"02d"}],"clouds":16,"pop":0,"uvi":6.12},{"dt":1695326400,"sunrise":1695304589,"sunset":1695348552,"moonrise":1695328920,"moonset":1695361980,"moon_phase":0.22,"summary":"There will be clear sky today","temp":{"day":291.65,"min":286.54,"max":292.89,"night":286.69,"eve":289.36,"morn":286.91},"feels_like":{"day":291.12,"night":286.37,"eve":289.02,"morn":286.51},"pressure":1011,"humidity":60,"dew_point":282.77,"wind_speed":5.84,"wind_deg":219,"wind_gust":6.31,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"clouds":0,"pop":0,"uvi":6.17},{"dt":1695412800,"sunrise":1695391039,"sunset":1695434857,"moonrise":1695419160,"moonset":1695451800,"moon_phase":0.25,"summary":"Expect a day of partly cloudy with clear spells","temp":{"day":290.91,"min":285.49,"max":292.24,"night":286.43,"eve":289.53,"morn":285.81},"feels_like":{"day":290.52,"night":285.95,"eve":289.21,"morn":285.43},"pressure":1015,"humidity":68,"dew_point":283.99,"wind_speed":4.84,"wind_deg":202,"wind_gust":5.11,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"clouds":0,"pop":0,"uvi":6.25},{"dt":1695499200,"sunrise":1695477490,"sunset":1695521163,"moonrise":1695509160,"moonset":0,"moon_phase":0.29,"summary":"You can expect clear sky in the morning, with partly cloudy in the afternoon","temp":{"day":292.76,"min":285.8,"max":292.85,"night":287.34,"eve":287.95,"morn":286.35},"feels_like":{"day":292.26,"night":287.09,"eve":287.71,"morn":285.79},"pressure":1015,"humidity":57,"dew_point":282.59,"wind_speed":3.97,"wind_deg":206,"wind_gust":4.73,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"clouds":5,"pop":0,"uvi":6.19},{"dt":1695585600,"sunrise":1695563940,"sunset":1695607469,"moonrise":1695598560,"moonset":1695542220,"moon_phase":0.32,"summary":"There will be partly cloudy today","temp":{"day":293.34,"min":286.88,"max":293.34,"night":288.15,"eve":288.99,"morn":287.92},"feels_like":{"day":293.09,"night":288.06,"eve":288.82,"morn":287.49},"pressure":1014,"humidity":64,"dew_point":285.52,"wind_speed":4.41,"wind_deg":245,"wind_gust":5,"weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],"clouds":100,"pop":0,"uvi":5.97},{"dt":1695672000,"sunrise":1695650391,"sunset":1695693774,"moonrise":1695687480,"moonset":1695633120,"moon_phase":0.36,"summary":"There will be partly cloudy today","temp":{"day":292.51,"min":288.17,"max":292.51,"night":290.11,"eve":289.63,"morn":289.71},"feels_like":{"day":292.28,"night":290.08,"eve":289.58,"morn":289.67},"pressure":1017,"humidity":68,"dew_point":286.09,"wind_speed":5.25,"wind_deg":212,"wind_gust":7.32,"weather":[{"id":804,"main":"Clouds","description":"overcast clouds","icon":"04d"}],"clouds":98,"pop":0.2,"uvi":6},{"dt":1695758400,"sunrise":1695736842,"sunset":1695780081,"moonrise":1695775980,"moonset":1695724140,"moon_phase":0.4,"summary":"Expect a day of partly cloudy with rain","temp":{"day":295.82,"min":287.83,"max":295.82,"night":287.83,"eve":288.55,"morn":288.72},"feels_like":{"day":295.32,"night":287.29,"eve":288.03,"morn":288.63},"pressure":1018,"humidity":45,"dew_point":282.69,"wind_speed":5.99,"wind_deg":276,"wind_gust":8.54,"weather":[{"id":500,"main":"Rain","description":"light rain","icon":"10d"}],"clouds":7,"pop":0.44,"rain":0.5,"uvi":6},{"dt":1695844800,"sunrise":1695823293,"sunset":1695866387,"moonrise":1695864240,"moonset":1695815220,"moon_phase":0.44,"summary":"Expect a day of partly cloudy with clear spells","temp":{"day":295.16,"min":286.52,"max":295.41,"night":288.67,"eve":289.04,"morn":286.85},"feels_like":{"day":294.59,"night":288.29,"eve":288.67,"morn":286.1},"pressure":1017,"humidity":45,"dew_point":281.09,"wind_speed":5.01,"wind_deg":280,"wind_gust":5.83,"weather":[{"id":800,"main":"Clear","description":"clear sky","icon":"01d"}],"clouds":1,"pop":0,"uvi":6}]}';

        parent::setUp();
    }

    public function testIpAddressIsCorrectlyAssigned()
    {
        $forecastAPI = OpenWeatherAPI::create(new Client());
        $geolocationAPI = GeolocationIPAPI::create(new Client());

        $geolocationAPI = GeolocationIPAPI::create(new Client());
        $geolocationAPI->setIPAddress($this->genericIpAddress);

        $this->assertEquals($geolocationAPI->getIpAddress(), $this->genericIpAddress);
    }

    public function testLatLonAreCorrectlyAssigned()
    {
        $lon = 40;
        $lat = -30;

        $forecastAPI = OpenWeatherAPI::create(new Client());

        $forecastAPI->setLon($lon);
        $forecastAPI->setLat($lat);

        $this->assertEquals($forecastAPI->getLon(), $lon);
        $this->assertEquals($forecastAPI->getLat(), $lat);
    }

    public function testGetGeoLocation()
    {
        // Create a mock of the GeoLocationAPI class
        $mockGeoLocationAPI = $this->getMockBuilder(GeoLocationAPI::class)
            ->setMethods(['setIPAddress', 'getGeoLocation'])
            ->getMock();

        $ipAddress = '8.8.8.8';

        // Define the expected behavior of setIPAddress and getGeoLocation methods
        $mockGeoLocationAPI->expects($this->once())
            ->method('setIPAddress')
            ->with($ipAddress)
            ->willReturn($mockGeoLocationAPI); // Return $mockGeoLocationAPI to allow method chaining

        $mockGeoLocationAPI->expects($this->once())
            ->method('getGeoLocation')
            ->willReturn(['latitude' => 37.7749, 'longitude' => -122.4194]); // Define your expected return data here

        // Use the mock object to set the IP address and fetch geo-location data
        $result = $mockGeoLocationAPI
            ->setIPAddress($ipAddress)
            ->getGeoLocation();

        // Assert the result based on your expectations
        $this->assertEquals(['latitude' => 37.7749, 'longitude' => -122.4194], $result);
    }

    public function testInvalidIpAddressThrowsException()
    {
        $invalidIpAddress = 'invalid_ip_address';

        $this->expectException(InvalidArgumentException::class);

        $geolocationAPI = GeolocationIPAPI::create(new Client());
        $geolocationAPI->setIPAddress($invalidIpAddress);
        $geolocationAPI->getGeoLocation();

        WeatherForecast::create($geolocationAPI, $this->forecastAPI);
    }

    public function testGetGeolocationSuccess()
    {
        $this->geolocationAPI->expects($this->once())
            ->method('getGeoLocation')
            ->willReturn($this->responseJsonGeo);

        $geolocationData = $this->geolocationAPI->getGeoLocation();
        $geolocationData = json_decode($geolocationData);

        $this->assertNotNull($geolocationData);
        $this->assertEquals(37.7749, $geolocationData->lat);
        $this->assertEquals(-122.4194, $geolocationData->lon);
        $this->assertEquals('US', $geolocationData->countryCode);
        $this->assertEquals('San Francisco', $geolocationData->regionName);
    }

    public function testGetForecast()
    {
        // Create a mock of the ForecastAPI class
        $mockForecastAPI = $this->getMockBuilder(ForecastAPI::class)
            ->setMethods(['setApiKey', 'setLat', 'setLon', 'getForecast'])
            ->getMock();

        $apiKey = 'your-api-key';
        $lat = 37.7749;
        $lon = -122.4194;

        // Define the expected behavior of setApiKey, setLat, setLon, and getForecast methods
        $mockForecastAPI->expects($this->once())
            ->method('setApiKey')
            ->with($apiKey)
            ->willReturn($mockForecastAPI); // Return $mockForecastAPI to allow method chaining

        $mockForecastAPI->expects($this->once())
            ->method('setLat')
            ->with($lat)
            ->willReturn($mockForecastAPI);

        $mockForecastAPI->expects($this->once())
            ->method('setLon')
            ->with($lon)
            ->willReturn($mockForecastAPI);

        $mockForecastAPI->expects($this->once())
            ->method('getForecast')
            ->willReturn(['temperature' => 25, 'conditions' => 'Sunny']); // Define your expected return data here

        // Use the mock object to set API key, latitude, longitude, and fetch forecast data
        $result = $mockForecastAPI
            ->setApiKey($apiKey)
            ->setLat($lat)
            ->setLon($lon)
            ->getForecast(); // Call the renamed method

        // Assert the result based on your expectations
        $this->assertEquals(['temperature' => 25, 'conditions' => 'Sunny'], $result);
    }

}
