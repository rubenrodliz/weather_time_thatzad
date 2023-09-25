<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DailyWeatherController extends Controller
{
    public function getDailyWeather(string $zipCode) {
        // Obtenemos las coordenadas del código postal
        $GeoCodingCoordinates = new GeoCodingController();
        $coordinates = $GeoCodingCoordinates->getCoordinates($zipCode);

        // Realizamos la solicitud a la API
        $API_KEY = '004e173adb28f870bede682220c84c74';
        $client = new Client();
        $response = $client->request('GET', "https://api.openweathermap.org/data/2.5/onecall?lat={$coordinates['lat']}&lon={$coordinates['lon']}&exclude=minutely,hourly,alerts&lang=es&appid={$API_KEY}&units=metric");
        $data = json_decode($response->getBody(), true);

        // Traducción de valores 'main' del clima
        $mainClimaTraducido = [
            'Clear' => 'Despejado',
            'Clouds' => 'Nublado',
            'Rain' => 'Lluvia',
            'Drizzle' => 'Llovizna',
            'Thunderstorm' => 'Tormenta',
            'Snow' => 'Nieve',
            'Mist' => 'Niebla',
        ];

        // Obtener los datos diarios correspondientes a los próximos días
        $dailyData = [];
        foreach ($data['daily'] as $daily) {
            if (count($dailyData) === 4) {
                break;
            }
            $dia_dt = date('d', $daily['dt']);

            // Si el día es igual al día actual o está en el futuro
            if ($dia_dt > date('d')) {
                $daily['weather'][0]['main'] = $mainClimaTraducido[$daily['weather'][0]['main']];
                $daily['dt'] = date('d/m/Y', $daily['dt']);

                $mainClima = $mainClimaTraducido[$daily['weather'][0]['main']] ?? $daily['weather'][0]['main'];

                $dailyData[] = [
                    'date' => $daily['dt'],
                    'temperature' => round($daily['temp']['day']),
                    'weather' => $mainClima,
                    'icon' => $daily['weather'][0]['icon']
                ];
            }
        }

        return $dailyData;
    }
}
