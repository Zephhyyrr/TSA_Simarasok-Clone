<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DestinasiProvider extends Model
{
    use HasFactory;
    protected $fillable = [
        'destinasi_id',
        'provider_id',
        'signal',
    ];    
    
    function destinasi(){
        return $this->belongsTo(DestinasiPariwisata::class, 'destinasi_id');
    }
    function provider(){
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
