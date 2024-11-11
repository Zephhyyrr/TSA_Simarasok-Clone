<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSensor extends Model
{
    use HasFactory;
    protected $table = 'data_sensor';
    protected $fillable = [
        'tgl_',
        'winddirection',
        'windspeedavg',
        'windspeedmax',
        'airtemperature',
        'rainintensity1h',
        'rainintensity1d',
        'airhumidity',
        'airpressure',
        'lightintensity',
        'raindropstatus',
        'raindropintensity',
        'uvintensity',
        'uvindex',
    ];
}
