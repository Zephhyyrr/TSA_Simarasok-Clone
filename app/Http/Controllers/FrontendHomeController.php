<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Produk;
use GuzzleHttp\Client;
use App\Models\Homestay;
use Illuminate\Http\Request;
use App\Models\DestinasiPariwisata;
use App\Http\Controllers\Controller;
use App\Models\DataSensor;

class FrontendHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $destinasis = DestinasiPariwisata::latest()->get();
        $produk = Produk::latest()->get();
        $penginapan = Homestay::latest()->get();
        $latestPost = Post::latest()->published()->first();
        $dataSensor = DataSensor::latest()->first();


        // Menunggu API dari D3 Telekomunikasi
        $suhu = rand(10,30);

        // Menunggu data dari D4 Telekomunikasi


        return view('frontend.home.index')->with([
            'suhu' => $suhu,
            'destinasis' => $destinasis,
            'produk' => $produk,
            'homestay' => $penginapan,
            'latestPost' => $latestPost,
            'dataSensor' => $dataSensor,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
}
