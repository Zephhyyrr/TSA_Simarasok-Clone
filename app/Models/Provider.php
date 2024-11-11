<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    function relasi(){
        return $this->hasMany(DestinasiProvider::class, 'provider_id');
    }
}
