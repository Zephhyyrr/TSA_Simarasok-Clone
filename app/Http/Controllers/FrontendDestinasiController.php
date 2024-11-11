<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DestinasiPariwisata;

class FrontendDestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinasis = DestinasiPariwisata::latest()->cari()->paginate(6);
        return view('frontend.destinasi.index', ['destinasis' => $destinasis]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $destinasis = DestinasiPariwisata::with('media', 'provider')->find($id);
        if ($destinasis) {
            $destinasis->desc = $this->convertOembedToIframe($destinasis->desc);
            foreach ($destinasis->media as $media) {
                if ($media->tipe == 'youtube') {
                    $media->embedHtml = $this->convertUrlToIframe($media->nama);
                }
            }
        }
        $providers = $destinasis->providers;
        return view('frontend.destinasi.show', compact('destinasis', 'providers'));
    }

    private function convertOembedToIframe($content)
    {
        return preg_replace_callback(
            '/<oembed url="(https:\/\/youtu\.be\/[^"]+)"><\/oembed>/',
            function ($matches) {
                $url = $matches[1];
                $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);
                return '<iframe src="' . $embedUrl . '" frameborder="0" allowfullscreen class="youtube-iframe"></iframe>';
            },
            $content
        );
    }

    private function convertUrlToIframe($url)
    {
        $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);
        return '<iframe src="' . $embedUrl . '" frameborder="0" allowfullscreen class="youtube-iframe"></iframe>';
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
