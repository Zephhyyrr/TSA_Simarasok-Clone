@extends('frontend.layouts.main')

@section('content')
    <div class="hero-wrap hero-wrap-2 js-fullheight" style="position: relative; overflow: hidden; height: 100vh;">
        <div style="position: relative; width: 100%; height: 100%; padding-top: 56.25%;">
            <iframe
                src="{{$videoHightligh?$videoHightligh->embedUrl():'' }}"
                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen title="YouTube Video Background"
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
            </iframe>
        </div>
    </div>

    <div class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-2">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Simarasok</span>
                    <h2 class="mb-4">Daftar Video</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($videos as $video)
                    <div class="card mb-2 ml-10 vb col-12 col-lg-6 col-md-6" style="width: 50%;">
                        <div style="display: block; position: relative; width: 100%; height: 0; padding-top: 56.25%;">
                            <iframe
                                src="{{ $video->embedUrl() }}"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" class="card-img-top"
                                allowfullscreen frameborder="0">
                            </iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $video->title }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <style>
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .hero-wrap .overlay {
            z-index: 1;
        }

        .hero-wrap .container {
            position: relative;
            z-index: 2;
        }

        .video-thumbnail {
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .video-thumbnail img {
            transition: transform 0.3s ease-in-out;
        }

        .video-thumbnail:hover img {
            transform: scale(1.1);
        }

        .video-thumbnail .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .video-thumbnail:hover .overlay {
            opacity: 1;
        }

        .btn-play {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 40px;
            transition: transform 0.3s ease-in-out;
        }

        .video-thumbnail:hover .btn-play {
            transform: translate(-50%, -50%) scale(1.5);
        }

        .text h3 {
            margin-top: 15px;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
@endsection
