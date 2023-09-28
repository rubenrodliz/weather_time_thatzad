@extends('layouts.app')

@section('title', 'Weather App')

@section('content')
    <style>
        .results-table>div {
            background-color: #306C77;
        }

        @media screen and (max-width: 767px) {
            .results-table>div {
                background-color: hsla(189, 43%, 33%, 0.747);
            }
        }

        @media screen and (min-width: 768px) {
            .border-md-top-0 {
                border-top: 0 !important;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="logo-container text-center py-5">
            <img src="{{ asset('img/logo-resultado.svg') }}" alt="" class="img-fluid">
        </div>
        <div class="results-table d-flex justify-content-center flex-column flex-lg-row text-white mx-2">
            <div class="city-data d-flex flex-column justify-content-center flex-grow-1 p-3 mx-2 shadow">
                <div class="d-flex align-items-center justify-content-between justify-content-md-around ">
                    <div class="d-flex flex-column align-items-start">
                        <p class="fs-5 fs-md-4">
                            Código postal:
                            <span class="fw-bold fs-md-1">{{ $existingRecord->zip_code }}</span>
                        </p>
                        <p class="fs-5 fs-md-4">
                            Ciudad:
                            <span class="fw-bold fs-5">{{ $existingRecord->city }}</span>
                        </p>
                    </div>
                    <div class="ms-3">
                        <a href="{{ route('zipcode.index') }}" class="text-decoration-underline text-white fs-5">
                            <i class="fa-solid fa-magnifying-glass-location fa-2xl me-2" style="color: #ffffff;"></i>
                            <span class="d-none d-sm-inline">Buscar otra zona</span>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-around align-items-center flex-column flex-lg-row">
                    <div class="current-weather border-md-end">
                        <div class="text-center">
                            <h3 class="fw-light">Ahora</h3>
                        </div>
                        <div class="weather d-flex">
                            <div class="weather-icon">
                                <img src="http://openweathermap.org/img/wn/{{ $existingRecord->current_icon }}@2x.png" alt="{{ $existingRecord->current_weather }} icon">
                            </div>
                            <div class="weather data">
                                <p class="fs-5 fw-bold text-capitalize">{{ $existingRecord->current_weather }}</p>
                                <p class="fs-1 fw-bold">{{ $existingRecord->current_temperature }} º</p>
                            </div>
                        </div>
                    </div>
                    <div class="hourly-weather border-top border-md-end border-md-top-0 py-2">
                        <div class="text-center">
                            <h3 class="fw-light">Próximas horas</h3>
                        </div>
                        <div class="hourly-weather-table d-flex">
                            <div class="d-flex flex-column justify-content-center align-items-center border-end">
                                <p class="fs-5">Ahora </p>
                                <img src="http://openweathermap.org/img/wn/{{ $existingRecord['current_icon'] }}@2x.png"
                                    alt="">
                                <p class="fs-5">{{ $existingRecord['current_weather'] }}</p>
                                <p class="fs-5">{{ $existingRecord['current_temperature'] }} º</p>
                            </div>
                            @for ($i = 1; $i <= $existingRecord['quantity_of_hours']; $i++)
                                <div
                                    class="d-flex flex-column justify-content-center align-items-center {{ $i == $existingRecord['quantity_of_hours'] ? '' : 'border-end' }} px-md-2">
                                    <p class="fs-5">{{ $existingRecord["{$i}h_time"] }}</p>
                                    <img src="http://openweathermap.org/img/wn/{{ $existingRecord["{$i}h_icon"] }}@2x.png" alt="{{$existingRecord["{$i}h_weather"]}} icon">
                                    <p class="fs-5">{{ $existingRecord["{$i}h_weather"] }}</p>
                                    <p class="fs-5">{{ $existingRecord["{$i}h_temperature"] }} º</p>
                                </div>
                            @endfor

                        </div>
                    </div>
                    <div class="daily-weather border-top border-md-top-0 py-2">
                        <div class="text-center">
                            <h3 class="fw-light">Próximos días</h3>
                        </div>
                        <div class="hourly-weather-table d-flex">
                            @for ($i = 1; $i <= 4; $i++)
                                <div
                                    class="d-flex flex-column justify-content-center align-items-center {{ $i === 4 ? '' : 'border-end' }}">
                                    <p class="fs-5">{{ $existingRecord["{$i}day_time"] }}</p>
                                    <img src="http://openweathermap.org/img/wn/{{ $existingRecord["{$i}day_icon"] }}@2x.png" alt="{{$existingRecord["{$i}day_weather"]}} icon">
                                    <p class="fs-5">{{ $existingRecord["{$i}day_weather"] }}</p>
                                    <p class="fs-5">{{ $existingRecord["{$i}day_temperature"] }} º</p>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-temperatures mx-2 my-4 my-md-0 p-3 d-flex flex-column align-items-center shadow">
                <div class="w-75 text-center">
                    <h3 class="fw-light fs-lg-5">Top 5 de las zonas más frías según tus búsquedas</h3>
                </div>
                <div class="top-table w-75">
                    @foreach ($top5ColdestZipCodes as $index => $zipCode)
                        <div
                            class="top-{{ $index + 1 }} d-flex align-items-center justify-content-between {{ $index === 4 ? '' : 'border-bottom' }}">
                            <div class="col-2">
                                <p class="fs-5">{{ $index + 1 }}.</p>
                            </div>
                            <div class="col-3">
                                <p class="fs-1">{{ $zipCode['current_temperature'] }}º</p>
                            </div>
                            <div class="col">
                                <div class="d-flex flex-column justify-content-center">
                                    <p class="ms-3 mb-1">
                                        Ciudad:
                                        <span class="fw-bold fs-5">{{ $zipCode['city'] }}</span>
                                    </p>
                                    <p class="ms-3 mb-0">
                                        CP:
                                        <span class="fw-bold fs-5">{{ $zipCode['zip_code'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>




@endsection
