<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;
use App\Models\ZipCode; // Asegúrate de importar el modelo correcto

class HourlyWeatherController extends Controller
{
    public function getHourlyWeather(string $zipCode): void{
        // Obtenemos las coordenadas del código postal
        $GeoCodingCoordinates = new GeoCodingController();
        $coordinates = $GeoCodingCoordinates->getCoordinates($zipCode);

        // Realizamos la solicitud a la API
        $API_KEY = '004e173adb28f870bede682220c84c74';
        $client = new Client();
        $response = $client->request('GET', "https://api.openweathermap.org/data/2.5/onecall?lat={$coordinates['lat']}&lon={$coordinates['lon']}&exclude=minutely,daily,alerts&lang=es&appid={$API_KEY}&units=metric");

        $data = json_decode($response->getBody(), true);

        // Obtener la hora actual en formato de hora
        $hora_actual = now()->addHour()->addHour()->format('H');

        // Calcular las próximas 3 horas en formato de hora
        $horas_futuras = [];
        for ($i = 1; $i <= 3; $i++) {
            // Calcula la próxima hora sumando $i a la hora actual
            $hora_futura = (($hora_actual) + $i) % 24;
            $horas_futuras[] = $hora_futura;
        }

        // Obtener el día actual en formato de día
        $fecha_actual = date('d');

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

        // Obtener los datos horarios correspondientes a las próximas horas
        $hourlyData = [];
        foreach ($data['hourly'] as $hourly) {
            // Obtén la hora de la marca de tiempo UNIX
            $hora_dt = date('H', $hourly['dt']);
            // Obtén la fecha de la marca de tiempo UNIX en formato de día
            $fecha_dt = date('d', $hourly['dt']);

            // Verifica si la hora está en las próximas horas y la fecha es la misma que la fecha actual
            if (in_array($hora_dt, $horas_futuras) && $fecha_dt == $fecha_actual) {
                // Traduce el valor 'main' del clima
                $mainClima = $mainClimaTraducido[$hourly['weather'][0]['main']] ?? $hourly['weather'][0]['main'];
    
                $hourlyData[] = [
                    'time' => date('H:i', $hourly['dt']),
                    'temperature' => round($hourly['temp']),
                    'weather' => $mainClima,
                    'icon' => $hourly['weather'][0]['icon']
                ];
            }
        }

        // Almacenar los datos en la base de datos
        $zipCodeModel = ZipCode::where('zip_code', $zipCode)->first();
        if ($zipCodeModel) {
            // Almacenar los datos en los campos correspondientes
            $hourlyDataCount = count($hourlyData);
            for ($i = 1; $i <= $hourlyDataCount; $i++) {
                $zipCodeModel->update([
                    "quantity_of_hours" => $hourlyDataCount,
                    "{$i}h_time" => $hourlyData[$i - 1]['time'],
                    "{$i}h_weather" => $hourlyData[$i - 1]['weather'],
                    "{$i}h_temperature" => $hourlyData[$i - 1]['temperature'],
                    "{$i}h_icon" => $hourlyData[$i - 1]['icon']
                ]);
            }
        }
    }
}
