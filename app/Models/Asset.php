<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'tipe',
        'jenis',
        'jenis_id',
    ];

    private function convertToIframe($content)
    {
        return preg_replace_callback(
            'https:\/\/youtu\.be\/[^"]',
            function ($matches) {
                $url = $matches[1];
                $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);
                return '<iframe src="' . $embedUrl . '" frameborder="0" allowfullscreen></iframe>';
            },
            $content
        );
    }
}
