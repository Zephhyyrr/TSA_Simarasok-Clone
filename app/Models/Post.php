<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

//delete
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        // 'category',
        'status',
        'author_name',
    ];
    public function en(): HasOne{
        return $this->hasOne(PostEN::class, 'post_id');
    }
    public function hasEn(){
        return PostEN::where('post_id', $this->id)->exists();
    }
    function media(){
        return $this->hasMany(Asset::class, 'jenis_id')->where('jenis', 'post');
    }
    public function youtubeLinks()
    {
        return $this->hasMany(Asset::class, 'jenis_id')
                    ->where('jenis', 'post')
                    ->where('tipe', 'youtube');
    }

    public static function make_slug($judul) {
        return str_replace(' ', '-', strtolower($judul));
    }

    function scopeCari(Builder $query) : void {
        if (request('q')) {
            $query->where('title', 'like', '%'.request('q').'%');
        }
    }

    function scopePublished(Builder $query) : void {
        $query->where('status', 'publish');
    }
    function scopeHardNews(Builder $query) : void {
        $query->where('category', 'Hard News');
    }
    function scopeSoftNews(Builder $query) : void {
        $query->where('category', 'Soft News');
    }
    function scopeFeature(Builder $query) : void {
        $query->where('category', 'Feature');
    }

    function getCleanContentAttribute()
    {
        // Menghapus tag <p>
        return strip_tags($this->attributes['content']);
    }

}
