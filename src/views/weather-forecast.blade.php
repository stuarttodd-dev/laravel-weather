@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(isset($weatherData))
    <div>
        <!-- Display weather information here based on $weatherData -->
        <!-- You can format and style the data as needed -->
        @dump($weatherData)
    </div>
@else
    <form method="POST" action="{{ route('weather.fetch') }}">
        @csrf
        <div class="form-group">
            <label for="ip">Enter IP Address:</label>
            <input type="text" name="ip" id="ip" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Fetch Weather</button>
    </form>
@endif
