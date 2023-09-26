<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ZipCodeRequest;
use App\Http\Controllers\CurrentWeatherController;
use App\Http\Controllers\HourlyWeatherController;
use App\Http\Controllers\DailyWeatherController;
use App\Http\Controllers\Top5ColdestCitiesController;
use App\Models\ZipCode;
use Illuminate\Http\RedirectResponse;

class ZipCodeController extends Controller {
    public function index() {
        return view('index');
    }

    public function store(ZipCodeRequest $request): RedirectResponse {
        // Obtenemos el código postal introducido por el usuario
        $zipCode = $request->zip_code;

        // Realizamos la solicitud a la API y obtenemos los datos
        $currentWeatherController = new CurrentWeatherController();
        $data = $currentWeatherController->consultarAPI($zipCode);

        // Introducimos los datos en la base de datos
        $existingRecord = ZipCode::where('zip_code', $zipCode)->first();

        if ($existingRecord) {
            $existingRecord->update($data);
        } else {
            $currentWeather = ZipCode::create($data);
        }

        return redirect()->route('zipcode.show', ['codigoPostal' => $zipCode]);

        // SELECT `zip_code`, `city`, `temperature` FROM `zip_codes` order by temperature LIMIT 5;
    }

    public function show($codigoPostal) {
        $currentWeather = ZipCode::where('zip_code', $codigoPostal)->first();

        // Obtenemos los datos de la API de pronóstico por hora
        $hourlyWeatherController = new HourlyWeatherController();
        $hourlyWeather = $hourlyWeatherController->getHourlyWeather($codigoPostal);

        // Obtenemos los datos de la API para pronóstico diario
        $dailyWeatherController = new DailyWeatherController();
        $dailyWeather = $dailyWeatherController->getDailyWeather($codigoPostal);

        // Obtenemos el top 5 de códigos postales más fríos
        $Top5ColdestCitiesController = new Top5ColdestCitiesController();
        $top5ColdestZipCodes = $Top5ColdestCitiesController->getTop5ColdestZipCodes();

        return view('resultado', compact('currentWeather', 'hourlyWeather', 'dailyWeather', 'top5ColdestZipCodes'));
    }
}
