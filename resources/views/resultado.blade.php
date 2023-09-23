@extends('layouts.app')

@section('title', 'Weather App')

@section('content')
    <style>
        .results-table {
            background-color: #306C77;
        }
    </style>

    <div class="container-fluid d-flex justify-content-center align-items-center p-4">
        <img src="{{ asset('img/logo-resultado.svg') }}" alt="" class="image-fluid">
    </div>

    <div class="container-fluid d-flex flex-column text-white results-table">
        <div class="row">
            <div class="d-flex justify-content-center align-items-center">
                <div class="col-3">
                    <p>Código postal: <span class="fw-bold fs-5">{{ $currentWeather->zip_code }}</span></p>
                    <p>Ciudad: <span class="fw-bold fs-5">{{ $currentWeather->city }}</span></p>
                </div>
                <div class="col-3 action-button d-flex justify-content-end align-items-center">
                    <a href="{{ route('zipcode.index') }}" class="text-decoration-underline text-white">Buscar otra zona</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <p>Ahora</p>
                <div class="current-weather d-flex justify-content-center align-items-center">
                    <div class="weather-image">
                        <img src="http://openweathermap.org/img/wn/{{ $currentWeather->icon }}@2x.png" alt=""
                            class="image-fluid">
                    </div>
                    <div class="weather-details">
                        <p class="fs-6 fw-bold">{{ $currentWeather->weather }}</p>
                        <p class="fs-1 fw-bold">{{ $currentWeather->temperature }}°</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <table class="table">
                <thead>
                    <tr>
                        <th>Ciudad</th>
                        <th>Hora</th>
                        <th>Temperatura</th>
                        <th>Estado del tiempo</th>
                        <th>Icono</th> 
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $currentWeather->city }}</td>
                        <td>{{ $currentWeather->time }}</td>
                        <td>{{ $currentWeather->temperature }}</td>
                        <td>{{ $currentWeather->weather }}</td>
                        <td><img src="http://openweathermap.org/img/wn/{{$currentWeather->icon}}@2x.png" alt="Icon"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> --}}
@endsection
