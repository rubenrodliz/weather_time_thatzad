<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('zip_codes', function (Blueprint $table) {
            $table->id();
            $table->string('zip_code', 5);
            $table->string('city')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('current_time')->nullable();
            $table->string('current_weather')->nullable();
            $table->string('current_temperature')->nullable();
            $table->string('current_icon')->nullable();
            $table->string('quantity_of_hours')->nullable();
            $table->string('1h_time')->nullable();
            $table->string('1h_weather')->nullable();
            $table->string('1h_temperature')->nullable();
            $table->string('1h_icon')->nullable();
            $table->string('2h_time')->nullable();
            $table->string('2h_weather')->nullable();
            $table->string('2h_temperature')->nullable();
            $table->string('2h_icon')->nullable();
            $table->string('3h_time')->nullable();
            $table->string('3h_weather')->nullable();
            $table->string('3h_temperature')->nullable();
            $table->string('3h_icon')->nullable();
            $table->string('1day_time')->nullable();
            $table->string('1day_weather')->nullable();
            $table->string('1day_temperature')->nullable();
            $table->string('1day_icon')->nullable();
            $table->string('2day_time')->nullable();
            $table->string('2day_weather')->nullable();
            $table->string('2day_temperature')->nullable();
            $table->string('2day_icon')->nullable();
            $table->string('3day_time')->nullable();
            $table->string('3day_weather')->nullable();
            $table->string('3day_temperature')->nullable();
            $table->string('3day_icon')->nullable();
            $table->string('4day_time')->nullable();
            $table->string('4day_weather')->nullable();
            $table->string('4day_temperature')->nullable();
            $table->string('4day_icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zip_codes');
    }
};
