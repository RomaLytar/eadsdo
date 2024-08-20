<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\WeatherRequest;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    protected $weatherService;

    // Инъекция зависимости через конструктор
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @param WeatherRequest $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getWeather(WeatherRequest $request): JsonResponse
    {
        return $this->weatherService->getWeatherData($request->get('day'), $request->get('city') ?? env('CITY'));
    }
}
