<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class CurrentWeatherController extends Controller
{
    public function consultarAPI(string $zipCode): array{
        $API_KEY = '004e173adb28f870bede682220c84c74';

        // Realizamos la solicitud a la API
        $client = new Client();
        $response = $client->request('GET', "https://api.openweathermap.org/data/2.5/weather?lang=es&zip={$zipCode},ES&appid=004e173adb28f870bede682220c84c74&units=metric");

        // Decodificamos la respuesta de la API
        $data = json_decode($response->getBody());

        // Formateamos la fecha y hora
        $dt = new DateTime();
        $dt->setTimestamp($data->dt);
        $dt->setTimezone(new DateTimeZone('Europe/Madrid'));
        $formattedTime = $dt->format('H:i');

        // Extremos los datos que nos interesan
        $extractedData = [
            'zip_code' => $zipCode,
            'city' => $data->name,
            'time' => $formattedTime,
            'temperature' => $data->main->temp,
            'weather' => $data->weather[0]->description,
            'icon' => $data->weather[0]->icon
        ];

        // Devolvemos los datos en formato JSON
        return $extractedData;
    }
}
