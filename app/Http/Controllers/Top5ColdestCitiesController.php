<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZipCode;

class Top5ColdestCitiesController extends Controller {
    public function getTop5ColdestZipCodes()
    {
        // Realiza la consulta SQL para obtener los 5 códigos postales más fríos
        $top5ColdestZipCodes = ZipCode::select('zip_code', 'city', 'current_temperature')
            ->orderBy('current_temperature')
            ->limit(5)
            ->get();

        // Convierte los resultados en un array
        $resultArray = $top5ColdestZipCodes->toArray();

        return $resultArray;
    }

}