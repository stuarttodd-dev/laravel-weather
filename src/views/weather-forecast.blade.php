<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            border-radius: 5px 5px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #d9534f;
            border-radius: 5px;
            background-color: #f2dede;
            color: #a94442;
        }

        .alert-success {
            border-color: #3c763d;
            background-color: #dff0d8;
            color: #3c763d;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Weather Forecast</h3>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if(!empty($weatherData))
                <div class="alert alert-success">

                    @if(!empty($weatherData['geoLocation']))
                        <div class="mt-4">
                            <h4>Geo Location Data</h4>
                            <iframe
                                    style="float:right"
                                    width="300"
                                    height="170"
                                    frameborder="0"
                                    scrolling="no"
                                    marginheight="0"
                                    marginwidth="0"
                                    src="https://maps.google.com/maps?q={{ $weatherData['geoLocation']->lat }},{{ $weatherData['geoLocation']->lon }}&hl=es&z=14&amp;output=embed"
                            >
                            </iframe>
                            <ul>
                                <li><strong>Country:</strong> {{ $weatherData['geoLocation']->country }}</li>
                                <li><strong>Region:</strong> {{ $weatherData['geoLocation']->regionName }} ({{ $weatherData['geoLocation']->region }})</li>
                                <li><strong>City:</strong> {{ $weatherData['geoLocation']->city }}</li>
                                <li><strong>Zip Code:</strong> {{ $weatherData['geoLocation']->zip }}</li>
                                <li><strong>Latitude:</strong> {{ $weatherData['geoLocation']->lat }}</li>
                                <li><strong>Longitude:</strong> {{ $weatherData['geoLocation']->lon }}</li>
                                <li><strong>Timezone:</strong> {{ $weatherData['geoLocation']->timezone }}</li>
                                <li><strong>ISP:</strong> {{ $weatherData['geoLocation']->isp }}</li>
                                <li><strong>AS:</strong> {{ $weatherData['geoLocation']->as }}</li>
                                <li><strong>Query IP:</strong> {{ $weatherData['geoLocation']->query }}</li>
                            </ul>
                        </div>
                    @endif

                    @if(!empty($weatherData['forecast']) && !empty($weatherData['forecast']->daily))
                        <div class="mt-4">
                            <h4>Forecast Data</h4>

                            @foreach ($weatherData['forecast']->daily as $key => $daily)
                                @if($key < 5)
                                    <div style="margin-bottom:15px">

                                        @if ($daily->weather[0]->main === 'Clouds')
                                            <img src="{{ asset('vendor/ecce-laravel-weather/cloudy.png') }}" alt="{{ $daily->weather[0]->main }}" title="{{ $daily->weather[0]->main }}" style="max-width: 50px; float: left; margin-right: 10px;" />
                                        @endif

                                        @if ($daily->weather[0]->main === 'Rain')
                                            <img src="{{ asset('vendor/ecce-laravel-weather/rainy.png') }}" alt="{{ $daily->weather[0]->main }}" title="{{ $daily->weather[0]->main }}" style="max-width: 50px; float: left; margin-right: 10px;" />
                                        @endif

                                        @if ($daily->weather[0]->main === 'Clear')
                                            <img src="{{ asset('vendor/ecce-laravel-weather/sunny.png') }}" alt="{{ $daily->weather[0]->main }}" title="{{ $daily->weather[0]->main }}" style="max-width: 50px; float: left; margin-right: 10px;" />
                                        @endif

                                        {{ $daily->weather[0]->main }}
                                        <ul style="list-style-type: none; margin: 0; padding: 0;">
                                            <li><strong>Day:</strong> {{ ($key + 1) }}</li>
                                            <li style="font-size:12px">{{ $daily->summary }}</li>
                                        </ul>

                                        <div style="clear: both;"></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
            <div style="margin-top:20px">
                <form method="POST" action="{{ route('weather.fetch') }}">
                    @csrf
                    <div class="form-group">
                        <label for="ip">Enter IP Address:</label>
                        <input type="text" name="ip" id="ip" class="form-control" required>
                    </div>
                    <button type="submit">Fetch Weather</button>
                </form>
            </div>

        </div>
    </div>
</div>
</body>
</html>
