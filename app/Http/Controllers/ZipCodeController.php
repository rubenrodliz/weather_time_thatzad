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

class ZipCodeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(ZipCodeRequest $request): RedirectResponse
    {
        // Obtenemos el código postal introducido por el usuario
        $zipCode = $request->zip_code;

        // Obtenemos la hora a buscar y comprobamos que no exista el registro
        $currentTime = now()->addHour()->addHour()->format('H');
        $currentIntTime = intval($currentTime);
        $existingRecord = ZipCode::where('zip_code', $zipCode)->where('current_time', '=', $currentIntTime)->first();

        // Si existe, redirigimos a la vista de resultados
        if ($existingRecord) {
            // Almacenar $existingRecord en la sesión
            session(['existingRecord' => $existingRecord]);
            return redirect()->route('zipcode.show', compact('zipCode', 'existingRecord'));
        }

        // Si no existe, continuamos con el proceso

        // Obtenemos los datos de la API de tiempo actual
        $currentWeatherController = new CurrentWeatherController();
        $currentWeatherController->getCurrentWeather($zipCode);

        // Obtenemos los datos de la API de pronóstico por hora
        $hourlyWeatherController = new HourlyWeatherController();
        $hourlyWeatherController->getHourlyWeather($zipCode);

        // Obtenemos los datos de la API para pronóstico diario
        $dailyWeatherController = new DailyWeatherController();
        $dailyWeatherController->getDailyWeather($zipCode);

        return redirect()->route('zipcode.show', compact('zipCode'));
    }

    public function show($zipCode, $existingRecord = null)
    {
        // Recuperar $existingRecord de la sesión
        $existingRecord = session('existingRecord');

        if ($existingRecord) {
            // Obtenemos el top 5 de códigos postales más fríos
            $Top5ColdestCitiesController = new Top5ColdestCitiesController();
            $top5ColdestZipCodes = $Top5ColdestCitiesController->getTop5ColdestZipCodes();

            return view('resultado', compact('existingRecord', 'top5ColdestZipCodes'));
        } 

        $existingRecord = ZipCode::where('zip_code', $zipCode)->first();

        // Obtenemos el top 5 de códigos postales más fríos
        $Top5ColdestCitiesController = new Top5ColdestCitiesController();
        $top5ColdestZipCodes = $Top5ColdestCitiesController->getTop5ColdestZipCodes();

        return view('resultado', compact('existingRecord', 'top5ColdestZipCodes'));
    }
}