<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontendPostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->cari()->published()->paginate(3);
        // $sidebarPosts = Post::latest()->softNews()->take(3)->get()->merge(Post::latest()->feature()->take(3)->get());
        return view('frontend.post.index', [
            'posts' => $posts,
            // 'sidebarPosts' => $sidebarPosts,
        ]);
    }

    // public function hardNews()
    // {
    //     $posts = Post::latest()->cari()->published()->hardNews()->paginate(5);
    //     return view('frontend.post.hardNews', ['posts' => $posts]);
    // }

    // public function softNews()
    // {
    //     $posts = Post::latest()->cari()->published()->softNews()->paginate(6);
    //     return view('frontend.post.softNews', ['posts' => $posts]);
    // }

    // public function feature()
    // {
    //     $posts = Post::latest()->cari()->published()->feature()->paginate(6);
    //     return view('frontend.post.feature', ['posts' => $posts]);
    // }
    
    public function show($slug, $lang = 'id')
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Set locale for Carbon based on selected language
        if ($lang === 'en') {
            Carbon::setLocale('en');
            $postEN = $post->en;
            if ($postEN) {
                $post->title = $postEN->title;
                $post->content = $postEN->content;
            }
        } else {
            Carbon::setLocale('id'); // Assume 'id' for Indonesian
        }

        $post->content = $this->convertOembedToIframe($post->content);

        return view('frontend.post.show', compact('post', 'lang'));
    }

    private function convertOembedToIframe($content)
    {
        return preg_replace_callback(
            '/<oembed url="(https:\/\/youtu\.be\/[^"]+)"><\/oembed>/',
            function ($matches) {
                $url = $matches[1];
                $embedUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);
                return '<iframe src="' . $embedUrl . '" frameborder="0" allowfullscreen></iframe>';
            },
            $content
        );
    }
}
