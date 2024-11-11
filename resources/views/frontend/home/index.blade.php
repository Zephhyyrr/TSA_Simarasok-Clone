@extends('frontend.layouts.main')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="hero-wrap js-fullheight" style="position: relative;">
        <img src="/media/frontend/images/Home.jpg" alt="Background Image"
            style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
        <div class="overlay"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: -1;">
        </div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <span class="subheading">Welcome to Simarasok</span>
                    <h1 class="mb-4">Desa Wisata Sumatera Barat</h1>
                    <p class="caps">Project Base Learning Politeknik Negeri Padang</p>
                </div>
                <a href="javascript:void(0);" class="icon-video  d-flex align-items-center justify-content-center mb-4"
                    id="audio-control">
                    <span class="fa fa-play" id="play-icon"></span>
                </a>

                <audio id="audio-element" src="/media/frontend/audios/audio keindahan alam simarasok.mp3"
                    preload="auto"></audio>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const audioElement = document.getElementById('audio-element');
                        const playIcon = document.getElementById('play-icon');
                        const audioControl = document.getElementById('audio-control');

                        audioControl.addEventListener('click', function() {
                            if (audioElement.paused) {
                                audioElement.play();
                                playIcon.classList.remove('fa-play');
                                playIcon.classList.add('fa-pause');
                            } else {
                                audioElement.pause();
                                playIcon.classList.remove('fa-pause');
                                playIcon.classList.add('fa-play');
                            }
                        });
                        audioElement.addEventListener('ended', function() {
                            playIcon.classList.remove('fa-pause');
                            playIcon.classList.add('fa-play');
                        });
                    });
                </script>
            </div>
        </div>
    </div>


    {{-- <script>
        $(document).ready(function() {
            $('.popup-vimeo').magnificPopup({
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });
        });
    </script> --}}

    {{-- info --}}
    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ftco-search d-flex justify-content-center">
                        <div class="row">
                            <div class="col-md-12 nav-link-wrap">
                                <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <div class="nav-link mr-md-1" id="v-pills-1-tab" aria-selected="true"
                                        style="cursor: default">Informasi Terbaru</div>
                                </div>
                            </div>
                            <div class="col-md-12 tab-wrap">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel"
                                        aria-labelledby="v-pills-nextgen-tab">
                                        <form action="#" class="search-property-1">
                                            <div class="row no-gutters">
                                                @if ($dataSensor == null)
                                                @else
                                                    <div class="col-md d-flex">
                                                        <div class="form-group p-4 border-0">
                                                            <label for="cuaca">Cuaca</label>
                                                            @if ($dataSensor == null)
                                                                <p id="suhu">Tidak ada data cuaca</p>
                                                            @else
                                                            <div class="form-field" style="color: black">
                                                                <select id="cuaca" class="form-select" style="color:black">
                                                                    <option value="suhu" selected style="color: black">
                                                                        {{ $dataSensor ? 'Suhu : ' . $dataSensor->airtemperature . ' °C' : 'Suhu (°C): Tidak ada data' }}
                                                                    </option>
                                                                    <option value="kelembaban" style="color: black">
                                                                        {{ $dataSensor ? 'Intensitas Hujan : ' . $dataSensor->rainintensity1h . ' mm' : 'Intensitas Hujan/jam (%): Tidak ada data' }}
                                                                    </option>
                                                                    <option value="tekanan" style="color: black">
                                                                        {{ $dataSensor ? 'Kelembaban : ' . $dataSensor->airhumidity . ' %' : 'Kelembapan (%): Tidak ada data' }}
                                                                    </option>
                                                                    <option value="kecepatan angin" style="color: black">
                                                                        {{ $dataSensor ? 'Kecepatan Angin : ' . $dataSensor->windspeedavg . ' M/s' : 'Kecepatan Angin (M/s): Tidak ada data' }}
                                                                    </option>
                                                                    <option value="uvindex" style="color: black">
                                                                        {{ $dataSensor ? 'UV Index : ' . $dataSensor->uvindex : 'UV Index : Tidak ada data' }}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4 border-0">
                                                        <label for="">Berita Terbaru</label>
                                                        @if (isset($latestPost) && $latestPost)
                                                            <p style="color: black">{{ $latestPost->title }}</p>
                                                            <a
                                                                href="{{ route('post.detail', ['slug' => $latestPost->slug]) }}">Baca
                                                                Selengkapnya</a>
                                                        @else
                                                            <p>No news available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="ftco-section services-section">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
                    <div class="w-100 text-justify">
                        <span class="subheading">Simarasok itu apa sih?</span>
                        <h2 class="mb-4">Simarasok</h2>
                        <p>Nagari Simarasok, sebuah desa wisata yang asri di dataran tinggi Kabupaten Agam, Sumatera Barat,
                            menyambut para wisatawan dengan pesonanya. Terletak sekitar 108 km dari ibukota provinsi
                            Sumatera Barat, desa ini dapat ditempuh dalam waktu 3-4 jam perjalanan.</p>
                        <p>Nama "Simarasok" sendiri berasal dari kata "Sei Marasok", yang berarti "sungai yang meresap". Hal
                            ini mencerminkan kondisi geografis desa yang diapit oleh perbukitan kapur yang memiliki banyak
                            gua dan aliran sungai bawah tanah.</p>
                        <div id="more-content" style="display: none">
                            <p>Membentang seluas 1789 Ha dengan ketinggian 800-1200 mdpl, Nagari Simarasok terdiri dari
                                empat jorong: Jorong Simarasok, Jorong Sungai Angek, Jorong Koto Tuo, dan Jorong Kampeh.
                                Desa ini memiliki iklim tropis dengan kelembaban udara rata-rata 83%-88% dan temperatur
                                berkisar antara 20°C hingga 29°C.</p>
                            <p>Sejak tahun 2022, Nagari Simarasok telah resmi ditetapkan sebagai desa wisata dengan
                                klasifikasi desa wisata berkembang. Desa ini menawarkan berbagai daya tarik wisata yang
                                memadukan keindahan alam, nilai historis, dan kearifan lokal, dikemas dalam aktivitas wisata
                                adventure tourism.</p>
                            <p>Desa Wisata Simarasok adalah destinasi wisata ideal bagi para pecinta alam, petualangan, dan
                                budaya yang ingin merasakan pengalaman autentik pedesaan Sumatera Barat, seperti memiliki
                                beberapa objek utama yaitu:</p>
                            <ul>
                                @foreach ($destinasis as $item)
                                    <li><a href="/list-destinasi/{{ $item->id }}">{{ $item->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <br>
                        <a id="read-more-btn" class="text-primary" onclick="showMore()">Selengkapnya</a>
                    </div>
                    <script>
                        function showMore() {
                            var moreContent = document.getElementById("more-content");
                            var readMoreBtn = document.getElementById("read-more-btn");

                            if (moreContent.style.display === "none" || moreContent.style.display === "") {
                                moreContent.style.display = "block";
                                readMoreBtn.innerHTML = "Sembunyikan";
                            } else {
                                moreContent.style.display = "none";
                                readMoreBtn.innerHTML = "Selengkapnya";
                            }
                        }
                    </script>

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate"
                            style="z-index: 2; position: relative">
                            <div class="services services-1 color-2 d-block img">
                                <img src="{{ asset('/media/frontend/images/Home.jpg') }}" alt="Background Image"
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
                                <a href="https://maps.app.goo.gl/UiZSwwi9qECuNaBcA">
                                    <div class="icon d-flex align-items-center justify-content-center"><span
                                            class="flaticon-route"></span></div>
                                    <div class="media-body">
                                        <h3 class="heading mb-3">Lokasi</h3>
                                        <p>Simarasok terletak di Kabupaten Agam, Sumatera Barat
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate"
                            style="z-index: 2; position: relative">
                            <div class="services services-1 color-1 d-block img" style="z-index: 2; position: relative">
                                <img src="{{ asset('/media/frontend/images/Home.jpg') }}" alt="Background Image"
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
                                <a
                                    href="https://www.instagram.com/pesona_simarasok?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
                                    <div class="icon d-flex align-items-center justify-content-center"><span
                                            class="fa-brands fa-instagram fs-1"></span></div>
                                    <div class="media-body">
                                        <h3 class="heading mb-3">Instagram</h3>
                                        <p>pesona_simarasok
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate"
                            style="z-index: 2; position: relative">
                            <div class="services services-1 color-3 d-block img">
                                <img src="{{ asset('/media/frontend/images/Home.jpg') }}" alt="Background Image"
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
                                <div class="icon d-flex align-items-center justify-content-center"><span
                                        class="fa-solid fa-users fs-2"></span></div>
                                <div class="media-body">
                                    <h3 class="heading mb-3">Ketua Kelompok Sadar Wisata</h3>
                                    <p>Ifnaldi
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate"
                            style="z-index: 2; position: relative">
                            <div class="services services-1 color-4 d-block img">
                                <img src="{{ asset('/media/frontend/images/Home.jpg') }}" alt="Background Image"
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
                                <a href="mailto:pesonasimarasokbaso@gmail.com">
                                    <div class="icon d-flex align-items-center justify-content-center"><span
                                            class="fa fa-envelope fs-2"></span></div>
                                    <div class="media-body">
                                        <h3 class="heading mb-3">Email</h3>
                                        <p style="word-wrap: break-word; overflow-wrap: break-word;">
                                            pesonasimarasokbaso@gmail.com
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- destinasi --}}
    <div class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Destinasi Pariwisata</span>
                    <h2 class="mb-4">Destinasi</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($destinasis as $index => $item)
                    @if ($index >= 6)
                    @break
                @endif
                <div class="col-md-4 ftco-animate">
                    <div class="project-wrap"
                        style="background-color: white; box-shadow: 0 4px 8px rgba(163, 163, 163, 0.2);">
                        @if (count($item->media) > 0)
                            <a href="{{ route('destinasi.show', ['id' => $item->id]) }}" class="img-wrapper">
                                <img src="{{ asset('media/' . $item->media[0]->nama) }}"
                                    alt="{{ $item->media[0]->nama }}" class="img">
                            </a>
                        @endif

                        <div class="text p-4">
                            <h3><a href="{{ route('destinasi.show', ['id' => $item->id]) }}"
                                    target="_blank">{{ strlen($item->name) > 20 ? substr($item->name, 0, 30) . '...' : $item->name }}</a>
                            </h3>
                            <p class="location mb-1 fs-12"><span class="fa fa-map-marker mr-2"> <a
                                        href="{{ $item->lokasi }}"></span>Lihat Lokasi</a></p>
                            <ul>
                                <span data-feather="percent" style="width: 16px; color: rgb(86, 86, 86)"></span>
                                @if ($item->harga == 0)
                                    <li style="color: rgb(86, 86, 86)">Gratis</li>
                                @else
                                    <li style="color: rgb(86, 86, 86)">
                                        RP.{{ number_format($item->harga, 2, ',', '.') }}/orang</li>
                                @endif
                            </ul>
                            <ul>
                                <a href=""></a>
                                <li style="color: black"><a
                                        href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $item->notelp) }}"
                                        style="color: inherit; text-decoration: none;">
                                        <span data-feather="phone-call" style="width: 16px"
                                            class="mr-2"></span>{{ $item->notelp }}
                                    </a></li>
                            </ul>
                            <ul>
                                <li class="btn btn-outline rounded-2 btn-sm mt-2"><a
                                        href="{{ route('destinasi.show', ['id' => $item->id]) }}">Detail</a></li>
                                {{-- ini kalau ada booking destinasi --}}
                                {{-- <li>
                                    <form method="POST" action="/booking-wisata">
                                        @csrf
                                        <input type="hidden" name="destinasi_id" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-primary rounded-2 btn-sm mt-2">Detail
                                            Destinasi</button>
                                    </form>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <div class="col text-center mt-4">
                <p><a href="/list-destinasi" class="btn btn-primary">Lihat Destinasi Lainnya</a></p>
            </div>
        </div>
    </div>
</div>

{{-- Produk --}}
<div class="ftco-section img ftco-select-destination" style="position: relative;">
    <img src="{{ asset('/media/frontend/images/GreyBG.jpg') }}" alt="Background Image"
        style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
    <div class="container" style="position: relative; z-index: 2;">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Kuliner dan Cinderamata</span>
                <h2 class="mb-4">Oleh-Oleh</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($produk as $index => $item)
                @if ($index >= 6)
                @break
            @endif
            <div class="col-md-4 ftco-animate">
                <div class="project-wrap"
                    style="background-color: white; box-shadow: 0 4px 8px rgba(163, 163, 163, 0.2);">
                    @if (count($item->media) > 0)
                        <a href="{{ route('produk.show', ['id' => $item->id]) }}" class="img-wrapper">
                            <img src="{{ asset('media/' . $item->media[0]->nama) }}"
                                alt="{{ $item->media[0]->nama }}" class="img">
                        </a>
                    @else
                        <div class="img"
                            style="background-color: #f8f9fa; align-items: center; justify-content: center; display: flex;">
                            <span style="color: #6c757d; font-size: 18px; text-align: center">Tidak ada
                                gambar</span>
                        </div>
                    @endif
                    <div class="text p-4">
                        <h3>
                            <a
                                href="{{ route('produk.show', ['id' => $item->id]) }}">{{ strlen($item->name) > 20 ? substr($item->name, 0, 30) . '...' : $item->name }}</a>
                        </h3>
                        <ul>
                            @if (is_null($item->harga))
                                <p> Disajikan pada {{ $item->event }}</p>
                            @else
                                <p> Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            @endif
                        </ul>
                        <ul>
                            <li class="btn btn-outline rounded-2 btn-sm mt-2"><a
                                    href="{{ route('produk.show', ['id' => $item->id]) }}">Detail</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row justify-content-center">
        <div class="col text-center mt-4">
            <p><a href="/list-produk" class="btn btn-primary">Lihat Produk Lainnya</a></p>
        </div>
    </div>
</div>
</div>


{{-- Homestay --}}
<div class="ftco-section">
<div class="container">
    <div class="row justify-content-center pb-4">
        <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Penginapan</span>
            <h2 class="mb-4">Penginapan</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach ($homestay as $index => $item)
            @if ($index >= 6)
            @break
        @endif
        <div class="col-md-4 ftco-animate">
            <div class="project-wrap"
                style="background-color: white; box-shadow: 0 4px 8px rgba(163, 163, 163, 0.2);">
                @if (count($item->media) > 0)
                    <a href="{{ route('homestay.show', ['id' => $item->id]) }}" class="img-wrapper">
                        <img src="{{ asset('media/' . $item->media[0]->nama) }}"
                            alt="{{ $item->media[0]->nama }}" class="img">
                    </a>
                @else
                    <div class="img"
                        style="background-color: #f8f9fa; align-items: center; justify-content: center; display: flex;">
                        <span style="color: #6c757d; font-size: 18px; text-align: center">Tidak ada
                            gambar</span>
                    </div>
                @endif
                <div class="text p-4">
                    <h3>
                        <a
                            href="{{ route('destinasi.show', ['id' => $item->id]) }}">{{ strlen($item->name) > 20 ? substr($item->name, 0, 30) . '...' : $item->name }}</a>
                    </h3>
                    {{-- <p class="location mb-1"><span class="fa fa-map-marker mr-2"></span>Lokasi</p> --}}
                    <ul>
                        <span data-feather="percent" style="width: 16px; color: rgb(86, 86, 86)"></span>
                        @if ($item->harga == 0)
                            {{-- Siapa tau ada v: --}}
                            <li style="color: rgb(86, 86, 86)">Gratis</li>
                        @else
                            <li style="color: rgb(86, 86, 86)">Rp
                                {{ number_format($item->harga, 2, ',', '.') }}/orang</li>
                        @endif
                    </ul>
                    <ul>
                        <li style="color: black">
                            <a href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $item->notelp) }}"
                                style="color: inherit; text-decoration: none;">
                                <span data-feather="phone-call" style="width: 16px"
                                    class="mr-2"></span>{{ $item->notelp }}
                            </a>
                        </li>
                    </ul>
                    <ul>
                        <li class="btn btn-outline rounded-2 btn-sm mt-2"><a
                                href="{{ route('homestay.show', ['id' => $item->id]) }}">Detail</a></li>
                        <li>
                            {{-- <form method="POST" action="/booking">
                                    @csrf
                                    <input type="hidden" name="homestay_id" value="{{ $item->id }}"> --}}
                            <a href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $item->notelp) }}"
                                target="_blank" class="btn btn-primary rounded-2 btn-sm mt-2">Pesan
                                Sekarang</a>
                            {{-- </form> --}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row justify-content-center">
    <div class="col text-center mt-4">
        <p><a href="/list-homestay" class="btn btn-primary">Lihat Penginapan Lainnya</a></p>
    </div>
</div>
</div>
</div>
@endsection
