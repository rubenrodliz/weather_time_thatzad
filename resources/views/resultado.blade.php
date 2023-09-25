@extends('layouts.app')

@section('title', 'Weather App')

@section('content')
    <style>
        .results-table {
            background-color: #306C77;
        }
    </style>

    <div class="container-fluid d-flex justify-content-center align-items-center flex-column">
        <div class="py-5">
            <img src="{{ asset('img/logo-resultado.svg') }}" alt="" class="image-fluid">
        </div>
        <div class="results-table">
            <div class="d-flex justify-content-center align-items-center text-white">
                <div>
                    <p class="fs-5">Código postal: <span class="fw-bold fs-4">{{ $currentWeather->zip_code }}</span></p>
                    <p class="fs-5">Ciudad: <span class="fw-bold fs-4">{{ $currentWeather->city }}</span></p>
                </div>
                <div>
                    <a href="{{ route('zipcode.index') }}" class="text-decoration-underline text-white fs-5"><i
                            class="fa-solid fa-magnifying-glass-location fa-2xl me-2" style="color: #ffffff;"></i>Buscar
                        otra zona </a>
                </div>
            </div>

            <!-- Sección para el clima actual y el pronóstico horario -->
            <div class="row">
                <div class="col-md-6">
                    <!-- Sección para el clima actual -->
                    <div class="text-center">
                        <h3>Ahora</h3>
                    </div>
                    <div class="d-flex col-3">
                        <div>
                            <img src="http://openweathermap.org/img/wn/{{ $currentWeather->icon }}@2x.png">
                        </div>
                        <div>
                            <p class="fs-5 fw-bold text-capitalize">{{ $currentWeather->weather }}</p>
                            <p class="fs-1 fw-bold">{{ $currentWeather->temperature }}°</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Sección para el pronóstico horario -->
                    <div class="hourly-forecast d-flex flex-row">
                        <p class="fs-5">Próximos partidos</p>

                        <!-- Ejemplo de iteración sobre $hourlyWeather para mostrar las próximas 4 horas -->
                        @foreach ($hourlyWeather as $hour)
                            <div class="hour">
                                <p class="fs-6">{{ $hour['time'] }}</p>
                                <p class="fs-6">{{ $hour['temperature'] }}°</p>
                                <img src="http://openweathermap.org/img/wn/{{ $hour['icon'] }}@2x.png" alt="" class="image-fluid">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <div class="current-weather d-flex justify-content-center align-items-center flex-column">
                    <div><h3>Ahora</h3></div>
                    <div class="weather-details d-flex flex-row">
                        <div class="weather-image">
                            <img src="http://openweathermap.org/img/wn/{{ $currentWeather->icon }}@2x.png" class="image-fluid">
                        </div>
                        <div class="weather-description">
                            <p class="fs-5 fw-bold text-capitalize">{{ $currentWeather->weather }}</p>
                            <p class="fs-1 fw-bold">{{ $currentWeather->temperature }}°</p>
                        </div>
                    </div>
                </div> --}}
    {{-- <div class="hourly-forecast d-flex flex-row">
                    <p class="fs-5">Próximos partidos</p> --}}
    {{-- Aquí puedes iterar sobre $hourlyWeather y mostrar las próximas 4 horas --}}
    {{-- @foreach ($hourlyWeather as $hour)
                        <div class="hour">
                            <p class="fs-6">{{ $hour['time'] }}</p>
                            <p class="fs-6">{{ $hour['temperature'] }}°</p>
                            <img src="http://openweathermap.org/img/wn/{{ $hour['icon'] }}@2x.png" alt=""
                            class="image-fluid">
                        </div>
                    @endforeach --}}
    {{-- </div> --}}
    {{--    </div>
        </div> --}}


    {{-- TODO: Mostrar el pronostico horario correctamente --}}
    {{-- {{var_dump($hourlyWeather)}} --}}
    </div>

@endsection
