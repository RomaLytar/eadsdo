<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use Illuminate\Console\Command;
use App\Models\Temperature;

class FetchAndStoreWeatherData extends Command
{
    const UNITS = 'metric';
    protected $signature = 'weather:fetch-and-store';
    protected $description = 'Fetch weather data from the API and store it in the database';
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    public function handle()
    {
        $city = env('CITY', 'Kyiv');
        // Получаем данные о погоде с API
        $data = $this->weatherService->fetchWeatherData($city);
        if (!empty($data)) {
            Temperature::createFromApiData($data);
            $this->info("Weather data for {$city} has been successfully fetched and stored.");
        } else {
            $this->error("Failed to fetch weather data for {$city}.");
        }
    }
}
