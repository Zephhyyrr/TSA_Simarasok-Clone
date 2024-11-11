@extends('frontend.layouts.main')

@section('content')
    <div class="hero-wrap hero-wrap-2 " style="background-image: url('/media/frontend/images/Home.jpg');height: 100px;">
        <div class="overlay" style="height: 100px;"></div>
    </div>
    <div class="container">
        <div class="row justify-content-center pb-2">
            <div class="col heading-section">
                <h2 class="mb-4 mt-4">Berita Simarasok</h2>
            </div>
            <div class="col-auto mt-4">
                <form action="/list-hard-news" method="GET" class="input-group">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="search" name="q" class="form-control" placeholder="Cari"
                            value="{{ request('q') }}" />
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            @if ($posts->count())
                @foreach ($posts as $post)
                    <div class="col-md-4 mb-4">
                        @if ($post->media->isNotEmpty())
                            <a href="{{ route('post.hardNewsDetail', $post->slug) }}">
                                <img src="{{ asset('media/' . $post->media->first()->nama) }}" class="img-fluid"
                                    style="width: 100%; height: 200px; object-fit: cover;" alt="{{ $post->title }}">
                            </a>
                        @else
                            <a href="{{ route('post.hardNewsDetail', $post->slug) }}">
                                <img src="{{ asset('path/to/placeholder/image.jpg') }}" class="img-fluid"
                                    style="width: 100%; height: 200px; object-fit: cover;" alt="Placeholder Image">
                            </a>
                        @endif
                        <h5><a href="{{ route('post.hardNewsDetail', $post->slug) }}">{{ $post->title }}</a></h5>
                        <span style="font-style: italic;"><i class="fa fa-calendar"></i> {{ $post->created_at->format('d M Y') }}</span>
                        <p>{{ Str::limit($post->content, 150) }}<a
                                href="{{ route('post.hardNewsDetail', $post->slug) }}">Selengkapnya</a></p>
                        {{-- <div class="card-footer text-muted">
                            Category: {{ $post->category }}
                        </div> --}}
                    </div>
                @endforeach
            @else
                <p>Hard News tidak ditemukan.</p>
            @endif
        </div>

        <div class="d-flex justify-content-center mt-4 mb-5">
            @if ($posts->lastPage() > 1)
                <div class="block-27">
                    <ul>
                        @if ($posts->onFirstPage())
                            <li class="disabled"><span>&lt;</span></li>
                        @else
                            <li><a href="{{ $posts->previousPageUrl() }}">&lt;</a></li>
                        @endif

                        @foreach ($posts->links()->elements as $element)
                            @if (is_string($element))
                                <li class="disabled"><span>{{ $element }}</span></li>
                            @endif
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $posts->currentPage())
                                        <li class="active"><span>{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($posts->hasMorePages())
                            <li><a href="{{ $posts->nextPageUrl() }}">&gt;</a></li>
                        @else
                            <li class="disabled"><span>&gt;</span></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
