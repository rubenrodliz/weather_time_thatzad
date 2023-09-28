<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\ZipCode; 

class DailyWeatherController extends Controller
{
    public function getDailyWeather(string $zipCode)
    {
        try {

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

            $diasSemanaTraducido = [
                'Monday' => 'Lunes',
                'Tuesday' => 'Martes',
                'Wednesday' => 'Miércoles',
                'Thursday' => 'Jueves',
                'Friday' => 'Viernes',
                'Saturday' => 'Sábado',
                'Sunday' => 'Domingo',
            ];

            // Obtener la fecha actual en formato de día
            $fecha_actual = date('d');

            // Inicializar arrays para cada día
            $dailyData = [];

            // Obtener los datos diarios correspondientes a los próximos días
            foreach ($data['daily'] as $daily) {
                if (count($dailyData) === 5) {
                    break;
                }
                $dia_dt = date('d', $daily['dt']);

                // Verificar si la fecha es mayor o igual a la fecha actual
                if ($dia_dt >= $fecha_actual) {
                    $daily['weather'][0]['main'] = $mainClimaTraducido[$daily['weather'][0]['main']];

                    // Traducir el día de la semana
                    $daily['dt'] = date('l', $daily['dt']);
                    $diaTraducido = $diasSemanaTraducido[$daily['dt']] ?? $daily['dt'];

                    // Traducir el clima
                    $mainClima = $mainClimaTraducido[$daily['weather'][0]['main']] ?? $daily['weather'][0]['main'];

                    // Almacenar los datos en el array correspondiente según el día
                    $dailyData[] = [
                        'date' => $diaTraducido,
                        'temperature' => round($daily['temp']['day']),
                        'weather' => $mainClima,
                        'icon' => $daily['weather'][0]['icon']
                    ];
                }
            }

            // Almacenar los datos en la base de datos
            $zipCodeModel = ZipCode::where('zip_code', $zipCode)->first();
            if ($zipCodeModel) {
                for ($i = 1; $i <= 5; $i++) {
                    if (isset($dailyData[$i - 1])) {
                        $zipCodeModel->update([
                            "{$i}day_time" => $dailyData[$i - 1]['date'],
                            "{$i}day_weather" => $dailyData[$i - 1]['weather'],
                            "{$i}day_temperature" => $dailyData[$i - 1]['temperature'],
                            "{$i}day_icon" => $dailyData[$i - 1]['icon']
                        ]);
                    }
                }
            }
        } catch (RequestException $e) {
            // Si hay un error, redirigimos a la página de error
            return redirect()->route('error')->with('error', 'Ha ocurrido un error al consultar la API');
        }

    }
}