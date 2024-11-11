@extends('frontend.layouts.main')

@section('content')
    <link rel="stylesheet" href="/css/Show.css">
    <div class="hero-wrap hero-wrap-2" style="height: 100px; background-color: rgb(0, 0, 0)">
        <div class="overlay" style="height: 100px; background-color: rgb(0, 0, 0); color: black"></div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-9">
                <h1>{{ $post->title }}</h1>
                <span style="font-style: italic;"><i class="fa fa-calendar"></i>
                    {{ $post->created_at->translatedFormat('d F Y') }}</span>
                </br>
                <span>
                    <i class="fa fa-user"></i>
                    {{ $post->author_name ?? 'Admin' }}
                </span>
            </div>
            <div class="col-3 mt-2">
                <!-- tombol tampilan bahasa -->
                <div class="d-flex justify-content-end mb-3">
                    <a id="btn-bahasa-id" href="{{ route('post.detail', ['slug' => $post->slug, 'lang' => 'id']) }}"
                        class="btn btn-outline-primary me-1 {{ $lang === 'id' ? 'active' : '' }}">ID</a>
                    <a id="btn-bahasa-en" href="{{ route('post.detail', ['slug' => $post->slug, 'lang' => 'en']) }}"
                        class="btn btn-outline-primary {{ $lang === 'en' ? 'active' : '' }}">EN</a>
                </div>
            </div>
        </div>
        {{-- <p>Category: {{ $post->category }}</p> --}}
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="ftco-animate col-lg-6">
                <div id="slider" class="carousel slide mb-3">
                    <div class="carousel-indicators" style="position: absolute; top: 10px; height: 30px;">
                        @if ($post->media->count() > 0)
                            @foreach ($post->media as $index => $media)
                                <button type="button" data-bs-target="#slider" data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}"
                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        @endif
                    </div>
                    <div class="carousel-inner">
                        @if ($post->media->count() > 0)
                            @foreach ($post->media as $index => $media)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    @if ($media->tipe == 'video')
                                        <video src="{{ asset('media/' . $media->nama) }}" loading="lazy"
                                            class="d-block w-100" controls muted autoplay></video>
                                    @elseif ($media->tipe == 'gambar')
                                        <img src="{{ asset('media/' . $media->nama) }}" loading="lazy"
                                            class="d-block w-100" alt="Gambar {{ $index + 1 }}">
                                    @elseif ($media->tipe == 'youtube')
                                        <iframe src="{{ strpos($media->nama, 'youtube.com') !== false ? str_replace('watch?v=', 'embed/', $media->nama) : (strpos($media->nama, 'youtu.be') !== false ? 'https://www.youtube.com/embed/' . explode('youtu.be/', $media->nama)[1] : $media->nama) }}"
                                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen height="300px" width="100%" class="d-block"
                                            style="z-index: 100;">
                                        </iframe>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <div class="img"
                                    style="background-color: #f8f9fa; align-items: center; justify-content: center; display: flex;">
                                    <span style="color: #6c757d; font-size: 18px; text-align: center">Tidak ada
                                        gambar</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev" style="width: 30px; height: 30px; padding: 5px; position: absolute; top: 50%; transform: translateY(-50%);">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next"style="width: 30px; height: 30px; padding: 5px; position: absolute; top: 50%; transform: translateY(-50%);">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="mt-4 mb-5 text-justify">
            @if ($lang === 'id')
                {!! $post->content !!}
            @elseif ($lang === 'en' && $post->hasEn())
                {!! $post->en->content !!}
            @else
                {!! $post->content !!}
            @endif
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnBahasaID = document.querySelector('#btn-bahasa-id');
            const btnBahasaEN = document.querySelector('#btn-bahasa-en');

            if (!{{ json_encode($post->hasEn()) }}) {
                // Jika tidak ada konten bahasa Inggris
                if (btnBahasaID) btnBahasaID.style.display = 'none';
                if (btnBahasaEN) btnBahasaEN.style.display = 'none';
            }

            // Event listener untuk tombol bahasa
            if (btnBahasaID) {
                btnBahasaID.addEventListener('click', () => {
                    // Logika untuk menampilkan konten bahasa Indonesia
                });
            }

            if (btnBahasaEN) {
                btnBahasaEN.addEventListener('click', () => {
                    // Logika untuk menampilkan konten bahasa Inggris
                });
            }
        });
    </script>
@endsection
