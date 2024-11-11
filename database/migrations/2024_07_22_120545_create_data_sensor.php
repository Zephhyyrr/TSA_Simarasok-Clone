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
        Schema::create('data_sensor', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->timestamp('tgl_')->nullable();
            $table->double('winddirection')->nullable();
            $table->double('windspeedavg')->nullable();
            $table->double('windspeedmax')->nullable();
            $table->double('airtemperature')->nullable();
            $table->double('rainintensity1h')->nullable();
            $table->double('rainintensity1d')->nullable();
            $table->double('airhumidity')->nullable();
            $table->double('airpressure')->nullable();
            $table->double('lightintensity')->nullable();
            $table->double('raindropstatus')->nullable();
            $table->double('raindropintensity')->nullable();
            $table->double('uvintensity')->nullable();
            $table->double('uvindex')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sensor');
    }
};
