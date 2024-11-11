<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Provider;
use App\Models\PageVisit;
use Illuminate\Http\Request;
use App\Models\DestinasiProvider;
use App\Models\DestinasiPariwisata;
use App\Http\Requests\StoreDestinasiPariwisataRequest;
use App\Http\Requests\UpdateDestinasiPariwisataRequest;

class DestinasiPariwisataController extends Controller
{
    // Display a listing of the resource.

    public function index(Request $request) {
        $query = $request->input('q');

        $destinasi = DestinasiPariwisata::latest()->cari()->paginate(10);

        foreach ($destinasi as $item) {
            $path = "list-destinasi/{$item->id}";
            $visits = PageVisit::where('path', $path)->first()->visits ?? 0;
            $item->visits = $visits;
        }

        return view("admin.destinasipariwisata.index", ['destinasis' => $destinasi, 'q' => $query]);
    }

    // Ini untuk index nya.. BTW name dari search nya ubah jadi q aja, biar pendek GET nya
    /*
        public function index() {
            $query = request('q');

            $destinasi = DestinasiPariwisata::latest()->cari($query)->paginate(10);

            return view("admin.destinasipariwisata.index", ['destinasis' => $destinasi, 'q' => $query]);
        }
    */

    // Show the form for creating a new resources.

    public function create() {
        $providers = Provider::all();
        return view('admin.destinasipariwisata.create')->with('providers', $providers);
    }

    // Store a newly created resource in storage.

    public function store(StoreDestinasiPariwisataRequest $request) {
        $data = $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'harga' => 'required|numeric',
            'notelp' => [
                'required',
                'regex:/^\+62\d+$/'
            ],
            'lokasi' => [
                'required',
                'regex:/^(https:\/\/www\.google\.com|https:\/\/maps)/'
            ],
            'status' => 'required'
        ], [
            'name.required' => 'Nama destinasi harus diisi.',
            'desc.required' => 'Deskripsi harus diisi.',
            'harga.required' => 'Harga harus diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'notelp.required' => 'Nomor telepon harus diisi.',
            'notelp.regex' => 'Nomor telepon harus diawali dengan +62 dan hanya berisi angka tanpa spasi.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'lokasi.regex' => 'Lokasi harus diawali dengan https://www.google.com/ atau https://mapsl/.',
            'status.required' => 'Masukkan Status'
        ]);
    
        $destinasi = DestinasiPariwisata::create($data);
    
        if ($request->hasFile('gambar')) {
            $i = 0;
            foreach($request->file('gambar') as $file) {
                $fileName = time() . $i++ . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('media'), $fileName);
                $asset = new Asset();
                $asset->nama = $fileName;
                $asset->tipe = in_array($file->getClientOriginalExtension(), ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'heic', 'HEIC',]) ? 'gambar' : 'video';
                $asset->jenis = 'destinasi';
                $asset->jenis_id = $destinasi->id;
                $asset->save();
            }
        }
        if ($request->filled('youtube_links')) {
            $youtubeLinks = json_decode($request->input('youtube_links'), true);
            
            foreach ($youtubeLinks as $link) {
                $asset = new Asset();
                $asset->nama = $link;
                $asset->tipe = 'youtube';
                $asset->jenis = 'destinasi';
                $asset->jenis_id = $destinasi->id;
                $asset->save();
            }
        }
        $providers = Provider::all();
        foreach ($request->input('providers') as $i => $providerStatus) {
            $p = $providers[$i];
            $provider = new DestinasiProvider();
            $provider->destinasi_id = $destinasi->id;
            $provider->provider_id = $p->id;
            $provider->signal = $providerStatus;
            $provider->save();
        }
    
        return redirect('admin/destinasipariwisata')->with('success', 'Berhasil menambahkan Destinasi Pariwisata baru.');
    }

    public function edit(string $id){
        $destinasi = DestinasiPariwisata::findOrFail($id);$providers = Provider::all();
        return view('admin.destinasipariwisata.edit',['destinasis'=> $destinasi,'providers'=> $providers]);
    }

    public function update(UpdateDestinasiPariwisataRequest $request, string $id) {
        $destinasi = DestinasiPariwisata::findOrFail($id);
    
        $data = $request->validate([
            'name' => 'required',
            'desc' => 'required',
            'harga' => 'required|numeric',
            'notelp' => [
                'required',
                'regex:/^\+62\d+$/'
            ],
            'lokasi' => [
                'required',
                'regex:/^(https:\/\/www\.google\.com|https:\/\/maps)/'
            ],
            'status' => 'required',
        ], [
            'name.required' => 'Nama destinasi harus diisi.',
            'desc.required' => 'Deskripsi harus diisi.',
            'harga.required' => 'Harga harus diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'notelp.required' => 'Nomor telepon harus diisi.',
            'notelp.regex' => 'Nomor telepon harus diawali dengan +62 dan hanya berisi angka tanpa spasi.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'lokasi.regex' => 'Lokasi harus diawali dengan https://www.google.com/ atau https://maps.',
            'status.required' => 'Masukkan Status',
        ]);
    
        $destinasi->update($data);
    
        if ($request->hasFile('gambar')) {
            $i = 0;
            foreach ($request->file('gambar') as $file) {
                $fileName = time() . $i++ . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('media'), $fileName);
                $asset = new Asset();
                $asset->nama = $fileName;
                $asset->tipe = in_array($file->getClientOriginalExtension(), ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'heic', 'HEIC',]) ? 'gambar' : 'video';
                $asset->jenis = 'destinasi';
                $asset->jenis_id = $destinasi->id;
                $asset->save();
            }
        }
    
        if ($request->filled('youtube_links')) {
            $youtubeLinks = json_decode($request->input('youtube_links'), true);
    
            // Hapus link YouTube lama
            Asset::where('jenis', 'destinasi')->where('jenis_id', $destinasi->id)->where('tipe', 'youtube')->delete();
    
            // Simpan link YouTube baru
            foreach ($youtubeLinks as $link) {
                $asset = new Asset();
                $asset->nama = $link;
                $asset->tipe = 'youtube';
                $asset->jenis = 'destinasi';
                $asset->jenis_id = $destinasi->id;
                $asset->save();
            }
        }
    
        $providers = Provider::all();
        foreach ($request->input('providers') as $i => $providerStatus) {
            $provider = DestinasiProvider::updateOrCreate(
                ['destinasi_id' => $destinasi->id, 'provider_id' => $providers[$i]->id],
                ['signal' => $providerStatus]
            );
        }
    
        return redirect('admin/destinasipariwisata')->with('warning', 'Berhasil mengubah data Destinasi Pariwisata.');
    }    

    public function destroy(string $id){
        $destinasi = DestinasiPariwisata::findOrFail($id);

        foreach ($destinasi->media as $media) {
            if (file_exists(public_path('media/' . $media->nama))) {
                unlink(public_path('media/' . $media->nama));
            }
            $media->delete();
        }
        foreach ($destinasi->provider as $provider) {
            $provider->delete();
        }

        $destinasi->delete();

        return redirect('admin/destinasipariwisata')->with('danger', 'Berhasil menghapus data Destinasi Pariwisata.');
    }
}
