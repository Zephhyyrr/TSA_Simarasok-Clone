<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class FrontendProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::latest()->cari()->paginate(9);
        return view('frontend.produk.index', compact('produks'));
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('frontend.produk.show', compact('produk'));
    }
}
