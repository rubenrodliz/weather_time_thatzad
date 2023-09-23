<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ZipCodeRequest;
use App\Http\Controllers\CurrentWeatherController;
use App\Http\Controllers\HourlyWeatherController;
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
    }

    public function show($codigoPostal) {
        $currentWeather = ZipCode::where('zip_code', $codigoPostal)->first();

        // Obtenemos los datos de la API de pronóstico por hora
        $hourlyWeatherController = new HourlyWeatherController();
        $hourlyWeather = $hourlyWeatherController->getHourlyWeather($codigoPostal);

        return view('resultado', compact('currentWeather', 'hourlyWeather'));
    }
}
