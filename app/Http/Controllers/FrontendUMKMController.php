<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\UMKM;
use Illuminate\Http\Request;

class FrontendUMKMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $umkm = UMKM::latest()->cari()->paginate(6);
        return view('frontend.umkm.index', ['umkms' => $umkm]);
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
        $umkms = UMKM::with('produk')->findOrFail($id);
        $produk = UMKM::findOrFail($id)->produk()->Cari()->get();
        // dd($produk);
        return view('frontend.umkm.show', ['umkm' => $umkms, 'produk' => $produk]);
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

    public function Produk(String $id)
    {
        $produk = Produk::findOrFail($id);
        return view('frontend.umkm.produk', compact('produk'));
    }
}
