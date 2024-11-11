@extends('frontend.layouts.main')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @media (max-width: 576px) {
            .btn.btn-primary {
                font-size: 12px !important;
                padding: 8px 16px !important;
                margin-top: 10px !important;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse-effect {
            animation: pulse 1.5s infinite;
        }
        @media (max-width: 768px){
            .contact-info {
                margin-left: 0;
            }
        }
        .contact-info {
            margin-left: -29px;
            justify-content: center;
        }

        .contact-info .col-md-3 {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .contact-info {
                margin-left: 0 !important;
            }

            .contact-info .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
    <div class="hero-wrap hero-wrap-2 js-fullheight" style="position: relative;">
        <img src="/media/frontend/images/Home.jpg" alt="Background Image"
            style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
        <div class="overlay"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: -1;">
        </div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="/">Home <i class="fa fa-chevron-right"></i></a></span>
                        <span>Hubungi Kami<i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Hubungi Kami</h1>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="ftco-section ftco-about img"style="background-image: url(/media/frontend/images/gambar1.jpg);">
        <div class="overlay"></div>
        {{-- <div class="container py-md-5">
            <div class="row py-md-5">
                <div class="col-md d-flex align-items-center justify-content-center">
                    <a href="https://vimeo.com/45830194"
                        class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
                        <span class="fa fa-play"></span>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="ftco-section ftco-about ftco-no-pt img mt-6">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-12 about-intro">
                    <div class="row">
                        <div class="col-md-6 d-flex">
                            <div class="img d-flex w-100 align-items-center justify-content-center"
                                style="margin-top: 50px; position: relative; width: 100%; padding-top: 56.25%;">
                                <img src="/media/frontend/images/Home.jpg" alt="Deskripsi Gambar"
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-5 py-5">
                            <div class="row justify-content-start pb-3">
                                <div class="col-md-12 heading-section ftco-animate">
                                    <span class="subheading">Tentang Kami</span>
                                    <h2 class="mb-4">Buatlah Kenangan Wisata yang Mengagumkan Bersama Kami</h2>
                                    <p class="text-justify">Nagari Simarasok merupakan nagari yang terletak di Kecamatan
                                        Baso, kabupaten Agam. Nagari Simarasok memiliki potensi alam yang luar biasa. Berada
                                        diketinggian 800 – 1200 mdpl dengan luas 1789 Ha nagari ini terbagi atas empat
                                        jorong yaitu jorong Simarasok, jorong Koto Tuo, jorong Kampeh dan jorong Sungai
                                        Angek. Memiliki suhu udara 20 – 24&deg;C dan curah hujan perbulannya 123,04 mm.
                                        Dengan jumlah penduduk 6.872 orang. Selain potensi alam tersebut, di Nagari
                                        Simarasok terdapat pula kekayaan budaya, kuliner dan edukasi.</p>
                                    <p><a href="/list-destinasi" class="btn btn-primary">Lihat Destinasi Sekarang</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12" style="text-align: left;">
                    <a class="btn btn-primary fs-6"
                        style="display: inline-flex; align-items: center; width: auto; max-width: 100%; margin-top: 30px; padding: 10px 20px; font-size: 14px; text-decoration: none; white-space: nowrap;">
                        Dengarkan lengkap tentang Simarasok
                    </a>
                </div>
            </div>
            <div class="ftco-section ftco-no-pb contact-section mb-4" style="padding: 3em 0;">
                <div class="container">
                    <div class="row d-flex contact-info">
                        @php
                            $audios = [
                                ['id' => 0, 'title' => 'Wonderful Simarasok', 'src' => '/media/frontend/audios/audio keindahan alam simarasok.mp3'],
                                ['id' => 1, 'title' => 'Kenapa Harus Simarasok?', 'src' => '/media/frontend/audios/Kenapa Harus Simarasok.mp3'],
                                ['id' => 2, 'title' => 'Pengelolaan Hutan Nagari Simarasok1', 'src' => '/media/frontend/audios/pengelolaan hutan nagari simarasok1.mp3'],
                                ['id' => 3, 'title' => "Inyiak Kalilaia's grave, Simarasok Tradition Culture", 'src' => '/media/frontend/audios/Podcast_out.mp3'],
                            ];
                        @endphp

                        @foreach ($audios as $audio)
                            <div class="col-md-3 d-flex">
                                <div class="align-self-stretch box p-4 text-center">
                                    <div class="icon d-flex align-items-center justify-content-center pulse-effect"
                                        style="background-color: #F15D30;">
                                        <a href="javascript:void(0);" class="audio-control"
                                            data-audio-id="{{ $audio['id'] }}">
                                            <span class="fa fa-play play-icon"
                                                style="align-items: center; color: white; margin-top: 10px;"></span>
                                        </a>
                                    </div>
                                    <h3 class="mb-2">{{ $audio['title'] }}</h3>
                                    {{-- <p style="color: black">{{ $audio['deskripsi'] }}</p> --}}
                                    <audio class="audio-element" src="{{ $audio['src'] }}" preload="auto"
                                        style="width: 100%; padding: 20px"></audio>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12" style="text-align: left;">
                    <a class="btn btn-primary fs-6"
                        style="display: inline-flex; align-items: center; width: auto; max-width: 100%; margin-top: 20px; padding: 10px 20px; font-size: 14px; text-decoration: none; white-space: nowrap;">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <div class="ftco-section ftco-no-pb contact-section mb-4" style="padding: 3em 0;">
                <div class="container">
                    <div class="row d-flex contact-info">
                        <div class="col-md-3 d-flex">
                            <div class="align-self-stretch box p-4 text-center">
                                <a href="https://maps.app.goo.gl/UiZSwwi9qECuNaBcA">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-location-pin"></span>
                                    </div>
                                    <h3 class="mb-2">Alamat</h3>
                                    <p style="color: black">Nagari Simarasok, Kecamatan Baso, Kabupaten Agam, Sumatera
                                        Barat</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="align-self-stretch box p-4 text-center">
                                <a href="https://api.whatsapp.com/send?phone=081374248212">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa-brands fa-whatsapp"></span>
                                    </div>
                                    <h3 class="mb-2">Nomor Kontak</h3>
                                </a>
                                <p><a href="https://api.whatsapp.com/send?phone=081374248212">081374248212 : Ifnaldi</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="align-self-stretch box p-4 text-center">
                                <a href="mailto:pesonasimarasokbaso@gmail.com">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-envelope"></span>
                                    </div>
                                    <h3 class="mb-2">Alamat Email</h3>
                                </a>
                                <p style="overflow-wrap: break-word; word-wrap: break-word; hyphens: auto; color: black">
                                    <a href="mailto:pesonasimarasokbaso@gmail.com">pesonasimarasokbaso@gmail.com</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex">
                            <div class="align-self-stretch box p-4 text-center">
                                <a
                                    href="https://www.instagram.com/pesona_simarasok?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa-brands fa-instagram"></span>
                                    </div>
                                    <h3 class="mb-2">Instagram</h3>
                                    <p><a
                                            href="https://www.instagram.com/pesona_simarasok?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">pesona_simarasok</a>
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const audioElements = document.querySelectorAll('.audio-element');
                    const audioControls = document.querySelectorAll('.audio-control');
                    const playIcons = document.querySelectorAll('.play-icon');
                    let currentlyPlaying = null;

                    audioControls.forEach((control, index) => {
                        const audioElement = audioElements[index];
                        const playIcon = playIcons[index];

                        control.addEventListener('click', function() {
                            audioElements.forEach((audio, i) => {
                                if (audio !== audioElement) {
                                    audio.pause();
                                    playIcons[i].classList.remove('fa-pause');
                                    playIcons[i].classList.add('fa-play');
                                }
                            });

                            if (audioElement.paused) {
                                audioElement.play();
                                playIcon.classList.remove('fa-play');
                                playIcon.classList.add('fa-pause');
                                currentlyPlaying = audioElement;
                            } else {
                                audioElement.pause();
                                playIcon.classList.remove('fa-pause');
                                playIcon.classList.add('fa-play');
                                currentlyPlaying = null;
                            }
                        });

                        audioElement.addEventListener('ended', function() {
                            playIcon.classList.remove('fa-pause');
                            playIcon.classList.add('fa-play');
                            if (currentlyPlaying === audioElement) {
                                currentlyPlaying = null;
                            }
                        });
                    });
                });
            </script>
@endsection
