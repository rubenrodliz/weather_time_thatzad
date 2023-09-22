<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\ZipCodeRequest;
use GuzzleHttp\Client;

class ZipCodeController extends Controller
{
    public function index() {
        return view('index');
    }

    public function store(ZipCodeRequest $request) {
        $zipCode = $request->input('zip_code');
        $API_KEY = '004e173adb28f870bede682220c84c74';

        $client = new Client();
        $url = "https://api.openweathermap.org/data/2.5/weather?zip={$zipCode},ES&appid={$API_KEY}&units=metric";
        $response = $client->request('GET', $url); 
        $data = json_decode($response->getBody(), true);

        return response()->json($data);
    }
}
