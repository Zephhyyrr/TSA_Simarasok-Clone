<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->cari()->paginate(10);

        return view('admin.video.index', ['videos'=>$videos, 'q'=>request('q')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'url' =>  [
                'required',
                'regex:/^(https:\/\/www.youtube.com|https:\/\/youtu.be)/'
            ],
        ],[
            'title' => 'Masukkan judul untuk ditampilkan',
            'url' =>  'Copy link youtube',
        ]);
        Video::create($validated);

        return redirect('admin/video')->with('success', 'Berhasil menambahkan video baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::findOrFail($id);
        return view('admin.video.edit', ['video'=>$video]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $video = Video::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required',
            'url' =>  [
                'required',
                'regex:/^(https:\/\/www.youtube.com|https:\/\/youtu.be)/'
            ],
        ],[
            'title' => 'Masukkan judul untuk ditampilkan',
            'url' =>  'Copy link youtube',
        ]);

        $video->update($validated);

        return redirect('admin/video')->with('warning', 'Berhasil mengubah data video.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Video::destroy($id);
        return redirect('admin/video')->with('danger', 'Video berhasil dihapus.');
    }

    public function toggleHighlight(Request $request, string $id)
    {
        $video = Video::findOrFail($id);
        if ($request->status) {
            $video->setHighlight();
            return redirect('admin/video')->with('success', 'Video highlighted successfully!');
        }else {
            $video->update(['highlight'=>false]);
            return redirect('admin/video')->with('danger', 'Tidak ada video highlight');
        }

    }
}
