<p align="center"><a href="https://laravel.com" target="_blank"><img src="public/img/logo-resultado.svg" width="400" alt="Laravel Logo"></a></p>


## Sobre Thatz Weather

Thatz Weather es un proyecto que permite consultar el clima de cualquier ciudad dentro del terriotorio español. Para ello, se ha utilizado la API de OpenWeatherMap, que permite consultar el clima de cualquier ciudad del mundo. La aplicación ha sido desarrollada con el framework Laravel, utilizando el patrón de diseño MVC. Y, para el front-end se ha utilizado Bootstrap 5.

- API utilizada: [OpenWeatherMap API](https://openweathermap.org/).
- Framework de backend: [Larvel 10x](https://laravel.com/).
- Framework de frontend: [Bootstrap v5.3](https://getbootstrap.com/) y [Font Awesome](https://fontawesome.com/) para los iconos.
- Tipografía utilizada: [Mulish](https://fonts.google.com/specimen/Mulish?query=mu).
- Base de datos utilizada: [MySQL (XAMPP)](https://www.apachefriends.org/es/index.html).

## Uso de la aplicación

Para utilizar la aplicación es necesario tener instalado MySQL, en mi caso, he trabajado con XAMPP. Una vez instalado, es necesario crear una base de datos llamada `thatz_weather` y, posteriormente, realizar un `php artisan migrate` para aplicar las migraciones de la base de datos. <br>
Seguidamente, ejecutar `php artisan serve` para levantar el servidor de Laravel. Y, ejecutar `npm run dev` para compilar SAP CSS y JS. <br>
Por último, acceder a la ruta `http://localhost:8000/` para acceder a la aplicación.

### Distribución de la aplicación

La aplicación se divide en dos partes: la parte actualizada y la parte histórica. <br>

#### Parte actualizada

En la parte actualizada, se muestra el clima actual de la ciudad consultada. Para ello, se muestra:

- Nombre de la ciudad.
- Código postal
- Meteorología actual:
  - Icono de la meteorología actual.
  - Meteorología actual.
  - Temperatura actual.
- Pronóstico de la meteorología para las próximas horas del día actual:
  - Hora.
  - Icono de la meteorología.
  - Meteorología.
  - Temperatura.
- Pronóstico de la meteorología para los próximos 4 días:
  - Día.
  - Icono de la meteorología.
  - Meteorología.
  - Temperatura.

#### Parte histórica

En la parte histórica, se muestra un histórico de las ciudades consultadas con la temperatura más baja. Para ello, se muestra:

- Posición en el ranking de temperaturas más bajas.
- Temperatura más baja registrada.
- Nombre de la ciudad.
- Código postal.