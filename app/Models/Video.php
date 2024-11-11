<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'highlight',
    ];

    function embedUrl(){
        $videoId = Str::afterLast($this->url, '/');
        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
        return $embedUrl;
    }

    function scopeCari(Builder $query) : void {
        if (request('q')) {
            $query->where('title', 'like', '%'.request('q').'%');
        } 
    }

    function setHighlight(){
        DB::transaction(function () {
            $videos = Video::all();
            foreach ($videos as $video) {
                $video->update(['highlight' => false]);
            }
            $this->update(['highlight' => true]);
        });
    }

    public static function getHighlight(){
        return Video::where('highlight', true);
    }
}
