<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Temperature;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    const COUNT_ATTEMPT_API = 3; //кол-во попыток
    const DELEY = 5; // Задержка в секундах

    /**
     * @param string $day
     * @param string $city
     * @return JsonResponse
     * @throws ApiException
     */
    public function getWeatherData(string $day, string $city): JsonResponse
    {
        // Получаем данные о погоде из базы данных
        $weather = Temperature::query()->where('city', $city)
            ->whereDate('recorded_at', $day)
            ->first();
        // Если данных нет
        if (!$weather) {
            throw new ApiException('No weather data found for the specified city and day.', 101);
        }
        return response()->json([
            'city' => $weather->city,
            'country_code' => $weather->country_code,
            'temperature' => $weather->temperature,
            'date' => $weather->recorded_at->format('Y-m-d')
        ]);
    }

    /**
     * Получить данные о погоде из внешнего API.
     *
     * @param string $city
     * @return array
     */
    public function fetchWeatherData(string $city): array
    {
        $apiKey = env('WEATHER_API_KEY');
        $attempts = self::COUNT_ATTEMPT_API;
        $delay = self::DELEY;

        for ($i = 0; $i < $attempts; $i++) {
            try {
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric',
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                Log::warning("Attempt $i: Failed to fetch weather data for {$city}. Error: " . $e->getMessage());
                sleep($delay);
            }
        }
        Log::error("Failed to fetch weather data for {$city} after $attempts attempts.");
        return [];
    }

}
