<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Homestay extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'desc',
        'notelp',
        'harga',
    ];

    function media(){
        return $this->hasMany(Asset::class, 'jenis_id')->where('jenis', 'homestay');
    }

    function bookingLog(){
        return $this->hasMany(Booking::class, 'homestay_id');
    }

    // Ini Scope yang kubuat gas, bisa pake ini aja kalau mau, tiba tiba rajin cuy (rajin, tapi copas ini dari kodingan sebelumnya EHEK)
    
    // function scopeCari(Builder $query, $term=NULL) {
    //     if(!empty($term)) {
    //         $query->where('name', 'like', '%' . $term . '%');
    //     }
    //     return $query;
    // }
    
    function scopeCari(Builder $query) : void {
        if (request('q')) {
            $query->where('name', 'like', '%'.request('q').'%');
        } 
    }
}
