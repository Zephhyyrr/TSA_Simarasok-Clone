<?php

namespace App\Http\Controllers;

use App\Models\DestinasiProvider;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::paginate(10);
        return view('admin.provider.index', ['providers'=>$providers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.provider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required|unique:providers',
        ],[
            'name'=>'Nama provider sudah ada',
        ]);
        Provider::create($validated);
        return redirect('admin/provider')->with('success','Provider Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Provider $Provider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.provider.edit',['provider'=>Provider::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name'=>'required|unique:providers',
        ],[
            'name'=>'Nama Provider tidak boleh sama dengan yang telah ada',
        ]);
        Provider::where('id',$id)->update($validated);
        return redirect('admin/provider')->with('warning','Provider Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $provider = Provider::findOrFail($id)->relasi;
        foreach ($provider as $value) {
            DestinasiProvider::destroy($value->id);
        }
        Provider::destroy($id);
        return redirect('admin/provider')->with('danger','Provider Berhasil Dihapus');
    }
}
