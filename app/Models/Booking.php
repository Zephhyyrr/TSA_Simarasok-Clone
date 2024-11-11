<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'notelp',
        'checkin',
        'checkout',
        'homestay_id',
        'status',
    ];

    function homestay(){
        return $this->belongsTo(Homestay::class, 'homestay_id');
    }

    // Ini Scope yang kubuat gas, bisa pake ini aja kalau mau, tiba tiba rajin cuy (rajin, tapi copas ini dari kodingan sebelumnya EHEK(Ini juga di copas lagi dari sebelumnya EHEK))
    // Belum tau ini berhasil atau enggak, soalnya pake orwherehas
    
    // function scopeCari(Builder $query, $term=NULL) {
    //     if(!empty($term)) {
    //         $query->where('name', 'like', '%' . $term . '%')
    //         ->orwherehas('homestay', function($qry) use ($term) {
    //             $qry->where('name', 'like', '%' . $term . '%');
    //         });
    //     }
    //     return $query;
    // }
    
    function scopeCari(Builder $query) : void {
        if (request('q')) {
            $query->where('name', 'like', '%'.request('q').'%')
                  ->orWhereHas('homestay', function($q) {
                    $q->where('name', 'like', '%'.request('q').'%');
                    });
        } 
    }
}
