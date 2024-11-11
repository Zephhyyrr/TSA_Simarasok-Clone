<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use Illuminate\Http\Request;

class FrontendHomestayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $homestays = Homestay::latest()->cari()->paginate(6);
        return view ('frontend.homestay.index',['homestays' => $homestays]);
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
    public function show(string $id)
    {
        $homestays = Homestay::with('media')->find($id);
        $homestays->desc = $this->convertOembedToIframe($homestays->desc);
        return view('frontend.homestay.show', compact('homestays'));
    }

    private function convertOembedToIframe($content)
    {
        return preg_replace_callback(
            '/<oembed url="(https:\/\/youtu\.be\/[^"]+)"><\/oembed>/',
            function ($matches) {
                $url = $matches[1];
                $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);
                return '<iframe src="' . $embedUrl . '" frameborder="0" allowfullscreen></iframe>';
            },
            $content
        );
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

    public function wagw(string $id) {
        $homestays = Homestay::with('media')->find($id);

        return view('frontend.homestay.formWA')->with(['homestay' => $homestays]);
    }

    public function wagwSend(Request $request) {
        $nama = $request->name;
        $target = $request->target;

        $token = 'tY2qgx#Zv4RkH22X_nNd';

        // nomor WA untuk API WA
        if (intval(strval($request->pemilik)[0]) == 0) {
            $wa = '62' . intval(substr(strval($request->pemilik), 1));
        }
        else {
            $wa = $request->pemilik;
        }

        $wa = "6282283094836";

        $link = "wa.me/$wa?text=" . urlencode("Hallo saya mau booking $request->homestay");

        $pesan = "Apakah anda $nama, ingin mem-booking $request->homestay.\nKlik link dibawah ini untuk menghubungi pemilik penginapan.\n\nNomor WhatsApp penginapan:\n$link\n\n *Abaikan jika bukan anda.*";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => "$target",
                'message' => "$pesan",
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            echo $error_msg;
        }

        return redirect('/list-homestay');
    }

}
