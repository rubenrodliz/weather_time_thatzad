<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GeoCodingController extends Controller {
    /**
     * Devuelve las coordenadas de un código postal
     * @param string $zipCode
     * @return array
     */
    public function getCoordinates(string $zipCode): array {
        // Almacenamos la API_KEY
        $API_KEY = '004e173adb28f870bede682220c84c74';

        // Realizamos la solicitud a la API
        $client = new Client();
        $response = $client->request('GET', "http://api.openweathermap.org/geo/1.0/zip?zip={$zipCode},ES&limit=3&appid={$API_KEY}");

        // Decodificamos la respuesta de la API
        $data = json_decode($response->getBody());

        // Extraemos los datos que nos interesan
        $extractedData = [
            'lat' => $data->lat,
            'lon' => $data->lon,
        ];

        return $extractedData;
    }
}