<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\ZipCode; // Asegúrate de importar el modelo correcto

class GeoCodingController extends Controller {
    public function getCoordinates(string $zipCode): array
    {
        // Buscar las coordenadas en la base de datos
        $zipCodeModel = ZipCode::where('zip_code', $zipCode)->first();

        if ($zipCodeModel && $zipCodeModel->lat && $zipCodeModel->lon) {
            // Si ya tenemos las coordenadas en la base de datos, las devolvemos
            return [
                'lat' => $zipCodeModel->lat,
                'lon' => $zipCodeModel->lon,
            ];
        } else {
            // Si no tenemos las coordenadas en la base de datos, hacemos la solicitud a la API
            $API_KEY = '004e173adb28f870bede682220c84c74';
            $client = new Client();
            $response = $client->request('GET', "http://api.openweathermap.org/geo/1.0/zip?zip={$zipCode},ES&limit=3&appid={$API_KEY}");

            // Decodificamos la respuesta de la API
            $data = json_decode($response->getBody());

            // Extraemos los datos que nos interesan
            $extractedData = [
                'lat' => $data->lat,
                'lon' => $data->lon,
            ];

            // Almacenar las coordenadas en la base de datos
            if ($zipCodeModel) {
                $zipCodeModel->update($extractedData);
            } else {
                ZipCode::create(array_merge(['zip_code' => $zipCode], $extractedData));
            }

            return $extractedData;
        }
    }
}
