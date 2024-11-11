<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Asset;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\PageVisit;
use App\Models\PostEN;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::latest()->cari()->paginate(10);

        foreach ($post as $item) {
            $path = "list-post/{$item->slug}";
            $visits = PageVisit::where('path', $path)->first()->visits ?? 0;
            $item->visits = $visits;
        }

        return view("admin.post.index")->with("posts", $post);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'gambar' => 'required',
        ]);

        $berita = Post::create([
            'title' => $request->title,
            'slug' => Post::make_slug($request->title),
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->has('status') ? 'publish' : 'draft',
            'author_name' => $request->input('author_name'),
        ]);

        if ($request->hasFile('gambar')) {
            $i = 0;
            foreach($request->file('gambar') as $file) {
                $fileName = time() . $i++ . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('media'), $fileName);
                $asset = new Asset();
                $asset->nama = $fileName;
                $asset->tipe = in_array($file->getClientOriginalExtension(), ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'heic', 'HEIC',]) ? 'gambar' : 'video';
                $asset->jenis = 'post';
                $asset->jenis_id = $berita->id;
                $asset->save();
            }
        }
        if ($request->filled('youtube_links')) {
            $youtubeLinks = json_decode($request->input('youtube_links'), true);
            foreach ($youtubeLinks as $link) {
                $asset = new Asset();
                $asset->nama = $link;
                $asset->tipe = 'youtube';
                $asset->jenis = 'post';
                $asset->jenis_id = $berita->id;
                $asset->save();
            }
        }

        if ($request->filled('enTitle') && $request->filled('enContent')) {
            PostEN::create([
                'post_id' => $berita->id,
                'title' => $request->input('enTitle'),
                'content' => $request->input('enContent'),
            ]);
        }

        return redirect('admin/post')->with('success', 'Berhasil menambahkan berita baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.edit')->with(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        // dd($request);
        $berita = Post::findOrFail($id);
        $data = [
            'title' => $request->title,
            'slug' => Post::make_slug($request->title),
            'content' => $request->content,
            'category' => $request->category,
            'status' => $request->has('status') ? 'publish' : 'draft',
            'author_name' => $request->input('author_name'),
        ];
        $berita->update($data);

        if ($request->hasFile('gambar')) {
            $i = 0;
            foreach ($request->file('gambar') as $file) {
                $fileName = time() . $i++ . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('media'), $fileName);
                $asset = new Asset();
                $asset->nama = $fileName;
                $asset->tipe = in_array($file->getClientOriginalExtension(), ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG', 'heic', 'HEIC',]) ? 'gambar' : 'video';
                $asset->jenis = 'post';
                $asset->jenis_id = $berita->id;
                $asset->save();
            }
        }

        if ($request->filled('youtube_links')) {
            $youtubeLinks = json_decode($request->input('youtube_links'), true);

            // Hapus link YouTube lama
            $berita->youtubeLinks()->delete();

            // Simpan link YouTube baru
            foreach ($youtubeLinks as $link) {
                $asset = new Asset();
                $asset->nama = $link;
                $asset->tipe = 'youtube';
                $asset->jenis = 'post';
                $asset->jenis_id = $berita->id;
                $asset->save();
            }
        }

        if ($request->filled('enTitle') && $request->filled('enContent')) {
            $postEN = PostEN::firstOrNew(['post_id' => $berita->id]);
            $postEN->title = $request->input('enTitle');
            $postEN->content = $request->input('enContent');
            $postEN->save();
        }

        return redirect('admin/post')->with('success', 'Berhasil memperbarui berita.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Post::findOrFail($id);

        foreach ($berita->media as $media) {
            if (file_exists(public_path('media/' . $media->nama))) {
                unlink(public_path('media/' . $media->nama));
            }
            $media->delete();
        }

        $berita->delete();

        return redirect('admin/post')->with('danger', 'Berhasil menghapus data berita.');
    }

    public function toggleStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->status = $post->status == 'publish' ? 'draft' : 'publish';
        $post->save();

        return redirect()->back()->with('status', 'Status updated successfully.');
    }

}
