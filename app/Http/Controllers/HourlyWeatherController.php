<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GeoCodingController;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;

class HourlyWeatherController extends Controller
{
    public function getHourlyWeather(string $zipCode)
    {
        // Obtenemos las coordenadas del código postal
        $GeoCodingCoordinates = new GeoCodingController();
        $coordinates = $GeoCodingCoordinates->getCoordinates($zipCode);

        // Realizamos la solicitud a la API
        $API_KEY = '004e173adb28f870bede682220c84c74';
        $client = new Client();
        $response = $client->request('GET', "https://api.openweathermap.org/data/2.5/onecall?lat={$coordinates['lat']}&lon={$coordinates['lon']}&exclude=minutely,daily,alerts&lang=es&appid={$API_KEY}&units=metric");

        $data = json_decode($response->getBody(), true);

        // Obtener la hora actual en formato de hora
        $hora_actual = date('H') + 1;

        // Calcular las próximas 3 horas en formato de hora
        $horas_futuras = [];
        for ($i = 1; $i <= 3; $i++) {
            // Calcula la próxima hora sumando $i a la hora actual
            $hora_futura = (($hora_actual + 1) + $i) % 24;
            $horas_futuras[] = $hora_futura;
        }

        // Obtener el día actual en formato de día
        $fecha_actual = date('d');

        // Obtener los datos horarios correspondientes a las próximas horas
        $hourlyData = [];
        foreach ($data['hourly'] as $hourly) {
            // Obtén la hora de la marca de tiempo UNIX
            $hora_dt = date('H', $hourly['dt']);
            // Obtén la fecha de la marca de tiempo UNIX en formato de día
            $fecha_dt = date('d', $hourly['dt']);

            // Verifica si la hora está en las próximas horas y la fecha es la misma que la fecha actual
            if (in_array($hora_dt, $horas_futuras) && $fecha_dt == $fecha_actual) {
                $hourlyData[] = $hourly;
            }
        }

        $extractedData = [];

        foreach ($hourlyData as $hourly) {
            // Formateamos la fecha y hora
            $dt = new DateTime();
            $dt->setTimestamp($hourly['dt']);
            $dt->setTimezone(new DateTimeZone('Europe/Madrid'));
            $formattedTime = $dt->format('H:i');

            // Extremos los datos que nos interesan
            $extractedData[] = [
                'time' => $formattedTime,
                'temperature' => $hourly['temp'],
                'weather' => $hourly['weather'][0]['description'],
                'icon' => $hourly['weather'][0]['icon']
            ];
        }

        // Devolvemos los datos en formato JSON
        return $extractedData;
    }
}