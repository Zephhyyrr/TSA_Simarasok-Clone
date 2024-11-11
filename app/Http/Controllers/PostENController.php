<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostEN;
use Illuminate\Http\Request;

class PostENController extends Controller
{
    public function destroyEN(string $id)
    {
        $berita = Post::findOrFail($id);
        $terjemahan = PostEN::findOrFail($berita->en->id);
        $terjemahan->delete();

        return redirect('admin/post')->with('danger', 'Berhasil menghapus versi Inggris "'.$berita->title.'".');
    }
}
