<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GeoCodingController;
use GuzzleHttp\Client;

class HourlyWeatherController extends Controller
{
    // TODO: Que te muestre solo las próximas 3 horas
    public function getHourlyWeather(string $zipCode): array{
        // Obtenemos las coordenadas del código postal
        $GeoCodingCoordinates = new GeoCodingController();
        $coordinates = $GeoCodingCoordinates->getCoordinates($zipCode);

        // Realizamos la solicitud a la API
        $API_KEY = '004e173adb28f870bede682220c84c74';
        $client = new Client();
        $response = $client->request('GET', "https://api.openweathermap.org/data/2.5/onecall?lat={$coordinates['lat']}&lon={$coordinates['lon']}&exclude=current,minutely,daily,alerts&lang=es&appid={$API_KEY}&units=metric");

        // Obtenemos los datos y los estructuramos
        $data = json_decode($response->getBody());
        $hourlyWeather = [];
        // URL base para los íconos del tiempo
        $iconBaseUrl = 'https://openweathermap.org/img/wn/';

        foreach ($data->hourly as $hour) {
            // Obtener la hora en formato legible
            $hourlyTime = date('H:i', $hour->dt);

            // Obtener la temperatura y descripción del tiempo
            $temperature = $hour->temp;
            $description = $hour->weather[0]->description;

            // Obtener el nombre del icono y construir la URL completa del ícono
            $iconName = $hour->weather[0]->icon;
            $iconUrl = $iconBaseUrl . $iconName . '@2x.png'; // Puedes ajustar el tamaño si es necesario

            // Agregar estos datos al array de pronóstico por hora
            $hourlyWeather[] = [
                'hour' => $hourlyTime,
                'temperature' => $temperature,
                'description' => $description,
                'icon_url' => $iconUrl,
            ];

            // Limitar el bucle a las próximas 3 horas
            if (count($hourlyWeather) >= 12) {
                break;
            }
        }

        return $hourlyWeather;

    }
}