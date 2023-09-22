@extends('layouts.app')

@section('title', 'Weather App')

@section('content')
    <style>
        #zipcode::placeholder {
            color: #fff;
            font-family: 'Mulish', sans-serif;
        }
    </style>

    <div class="container-fluid vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="row flex-grow-1 text-center">
            <img src="{{ asset('img/logo.svg') }}" alt="" class="image-fluid">
        </div>
        <div class="row flex-grow-1 d-flex justify-content-center align-items-center">
            <div class="mb-3 align-self-center text-center w-75 p-3">
                <p class="text-white fs-5">Entérate del tiempo en la zona exacta que te interesa buscando por código postal.</p>
                <form action="{{ route('buscar-cp') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control bg-transparent text-white" id="zipcode" placeholder="Introduce el código postal">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-info text-white w-100 fs-5">Buscar</button>
                    </div>
                </form>
            </div>
            <div class="row align-self-start mb-3 text-center">
                <p class="text-white fs-5 fw-700">¡Que la lluvia no te pare!</p>
            </div>
        </div>
    </div>
@endsection