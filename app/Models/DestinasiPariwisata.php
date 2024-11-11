<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DestinasiPariwisata extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'desc',
        'harga',
        'notelp',
        'lokasi',
        'status',
    ];

    function media(){
        return $this->hasMany(Asset::class, 'jenis_id')->where('jenis', 'destinasi');
    }
    public function youtubeLinks()
    {
        return $this->hasMany(Asset::class, 'jenis_id')
                    ->where('jenis', 'destinasi')
                    ->where('tipe', 'youtube');
    }

    function provider(){
        return $this->hasMany(DestinasiProvider::class, 'destinasi_id');
    }

    // Ini Scope yang kubuat gas, bisa pake ini aja kalau mau, tiba tiba rajin cuy
    /*
        function scopeCari(Builder $query, $term=NULL) {
            if(!empty($term)) {
                $query->where('name', 'like', '%' . $term . '%');
            }
            return $query;
        }
    */

    function scopeCari(Builder $query) : void {
        if (request('q')) {
            $query->where('name', 'like', '%'.request('q').'%');
        }
    }
}
