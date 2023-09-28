<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use App\Models\ZipCode;
use Illuminate\Http\Client\RequestException;

class CurrentWeatherController extends Controller
{
    public function getCurrentWeather(string $zipCode) {
        try {

            $API_KEY = '004e173adb28f870bede682220c84c74';

            // Realizamos la solicitud a la API
            $client = new Client();
            $response = $client->request('GET', "https://api.openweathermap.org/data/2.5/weather?lang=es&zip={$zipCode},ES&appid={$API_KEY}&units=metric");

            // Decodificamos la respuesta de la API
            $data = json_decode($response->getBody());

            // Formateamos la fecha y hora
            $dt = new DateTime();
            $dt->setTimestamp($data->dt);
            $dt->setTimezone(new DateTimeZone('Europe/Madrid'));
            $formattedTime = $dt->format('H');

            // Traducimos el estado del tiempo
            $mainClimaTraducido = [
                'Clear' => 'Despejado',
                'Clouds' => 'Nublado',
                'Rain' => 'Lluvia',
                'Drizzle' => 'Llovizna',
                'Thunderstorm' => 'Tormenta',
                'Snow' => 'Nieve',
            ];

            $weather = isset($mainClimaTraducido[$data->weather[0]->main])
                ? $mainClimaTraducido[$data->weather[0]->main]
                : $data->weather[0]->main;

            // Extremos los datos que nos interesan
            $extractedData = [
                'zip_code' => $zipCode,
                'city' => $data->name,
                'lat' => $data->coord->lat,
                'lon' => $data->coord->lon,
                'current_time' => $formattedTime,
                'current_weather' => $weather,
                'current_temperature' => round($data->main->temp),
                'current_icon' => $data->weather[0]->icon,
            ];

            // Guardar en la base de datos
            ZipCode::updateOrCreate(['zip_code' => $zipCode], $extractedData);
        } catch (RequestException $e) {
            // Si hay un error, redirigimos a la página de error
            return redirect()->route('error')->with('error', 'Ha ocurrido un error al consultar la API');
        }
    }
}