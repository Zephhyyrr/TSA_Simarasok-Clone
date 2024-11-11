<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'desc',
        'harga',
        'event',
        /* 'umkm_id',
        'category_id', */
    ];

    function media(){
        return $this->hasMany(Asset::class, 'jenis_id')->where('jenis', 'produk');;
    }

    /* function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    function umkm()
    {
        return $this->belongsTo(UMKM::class);
    } */

    function scopeCari(Builder $query) : void {
        if (request('q')) {
            $query->where('name', 'like', '%'.request('q').'%');
        }
    }
}
