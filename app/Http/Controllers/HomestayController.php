<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Homestay;
use App\Models\PageVisit;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $query = $request->input('q');

        // if (!empty($query)) {
        //     $homestay = Homestay::where("name", "like", "%" . $query . '%')->latest()->paginate(10);;
        // } else {
        //     $homestay = Homestay::latest()->paginate(10);
        // }
        // return view("admin.homestay.index", ['homestay' => $homestay, 'q' => $query]);

        $homestay = Homestay::latest()->cari()->paginate(10);
        
        foreach ($homestay as $item) {
            $path = "list-homestay/{$item->id}";
            $visits = PageVisit::where('path', $path)->first()->visits ?? 0;
            $item->visits = $visits;
        }

        return view("admin.homestay.index", ['homestay' => $homestay, 'q' => request('q')]);

    }


    // Ini index, sama kek destinasi, kuganti GET nya jadi q
    /*
        public function index()
        {
            $query = request('q');

            $homestay = Homestay::latest()->cari($query)->paginate(10);

            return view("admin.homestay.index", ['homestay' => $homestay, 'q' => $query]);
        }
    */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $homestay = Homestay::all();
        return view('admin.homestay.create')->with('$homestay', $homestay);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'harga' => 'required',
        ]);

        $homestay = Homestay::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'harga' => $request->harga,
            'notelp' => $request->notelp,
        ]);

        if ($request->hasFile('gambar')) {
            $i = 0;
            foreach($request->file('gambar') as $file) {
                $fileName = time() . $i . '.' . $file->getClientOriginalExtension();
                $i++;
                $file->move(public_path('media'), $fileName);
                $asset = new Asset();
                $asset->nama = $fileName;
                $asset->tipe = in_array($file->getClientOriginalExtension(), ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'heic', 'HEIC',]) ? 'gambar' : 'video';
                $asset->jenis = 'homestay';
                $asset->jenis_id = $homestay->id;
                $asset->save();
            }
        }

        // DestinasiPariwisata::create($destinasi);
        return redirect('admin/homestay')->with('success', 'Berhasil menambahkan Homestay baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Homestay $homestay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $homestay = Homestay::findOrFail($id);
        return view('admin.homestay.edit')->with('homestay', $homestay);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $homestay = Homestay::findOrFail($id);

        $data = [
            'name' => $request->name,
            'desc' => $request->desc,
            'harga' => $request->harga,
            'notelp' => $request->notelp,
        ];
        $homestay->update($data);

        if ($request->hasFile('gambar')) {
            $i = 0;
            foreach($request->file('gambar') as $file) {
                $fileName = time() . $i++ . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('media'), $fileName);
                $asset = new Asset();
                $asset->nama = $fileName;
                $asset->tipe = in_array($file->getClientOriginalExtension(), ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'heic', 'HEIC',]) ? 'gambar' : 'video';
                $asset->jenis = 'homestay';
                $asset->jenis_id = $homestay->id;
                $asset->save();
            }
        }
        return redirect('admin/homestay')->with('warning', 'Berhasil mengubah data Homestay.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $homestay = Homestay::findOrFail($id);

        foreach ($homestay->media as $media) {
            if (file_exists(public_path('media/' . $media->nama))) {
                unlink(public_path('media/' . $media->nama));
            }
            $media->delete();
        }

        $homestay->delete();

        return redirect('admin/homestay')->with('danger', 'Berhasil menghapus data Homestay.');
    }
}
