<?php

namespace App\Http\Controllers;

use App\Models\UMKM;
use App\Models\Produk;
use App\Http\Requests\StoreUMKMRequest;
use App\Http\Requests\UpdateUMKMRequest;
use Illuminate\Http\Request;

class UMKMController extends Controller
{
    // Display a listing of the resource.

    public function index() {

        $umkm = UMKM::latest()->cari()->paginate(10);

        return view("admin.umkm.index", ['umkms' => $umkm, 'q'=>request('q')]);
    }

    // Show the form for creating a new resources.

    public function create() {
        $umkm = UMKM::all();
        // $owner = User::all();
        return view('admin.umkm.create')->with(['umkms' => $umkm, /* 'owners' => $owner */]);
    }

    // Store a newly created resource in storage.

    public function store(StoreUMKMRequest $request) {
        $request->validate([
            'name' => 'required',
            'owner' => 'required',
            'notelp' => 'required',
            // 'user_id' => 'required|exists:users,id',
        ]);

        $umkm  = [
            'name' => $request -> name,
            'owner' => $request -> owner,
            'notelp' => $request -> notelp,
            // 'user_id' => $request -> user_id,
        ];

        UMKM::create($umkm);
        return redirect('admin/umkm')->with('success', 'Berhasil menambahkan UMKM baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.index', ['produks'=>$produk]);
    }

    public function edit(string $id)
    {
        $umkm = UMKM::findOrFail($id);
        return view('admin.umkm.edit')->with(['umkms' => $umkm]);
    }

    public function update(UpdateUMKMRequest $request, string $id)
    {
        $umkm = UMKM::findOrFail($id);

        $data = [
            'name' => $request->name,
            'owner' => $request -> owner,
            'notelp' => $request -> notelp,
            // 'user_id' => $request -> user_id,
        ];
        $umkm->update($data);

        return redirect('admin/umkm')->with('warning', 'Berhasil mengubah data UMKM.');
    }

    public function destroy(string $id)
    {
        $produk = Produk::where('umkm_id', $id)->delete();

        $umkm = UMKM::findOrFail($id);

        $umkm->delete();

        return redirect('admin/umkm')->with('danger', 'Berhasil menghapus data UMKM.');
    }
}
