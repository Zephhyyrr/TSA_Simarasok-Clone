<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function category()
    // {
    //     return $this->belongsTo(Category::class, 'category_id');
    // }

    // public static function categoryBerita() {
    //     return Category::where('jenis','Berita')->get();
    // }

    /* public static function categoryProduk() {
        return Category::All();
    } */

    function scopeCari(Builder $query) : void {
        if (request('q')) {
            $query->where('name', 'like', '%'.request('q').'%');
        }
    }
}
