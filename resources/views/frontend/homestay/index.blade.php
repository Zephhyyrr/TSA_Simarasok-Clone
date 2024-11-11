@extends('frontend.layouts.main')

@section('content')
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
                        <span>List Penginapan <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Daftar Penginapan</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <form action="/list-homestay" method="GET" class="input-group">
            <div class="form-outline flex-grow-1" data-mdb-input-init>
                <input type="search" name="q" class="form-control" placeholder="Cari Penginapan"
                    value="{{ request('q') }}" />
            </div>
            <button type="submit" class="btn btn-primary">
                <i data-feather="search"></i>
            </button>
        </form>
    </div>

    <div class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-2">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Simarasok</span>
                    <h2 class="mb-4">Daftar Penginapan</h2>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($homestays as $item)
                        <div class="col-md-4 ftco-animate">
                            <div class="project-wrap">
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
                                            href="{{ route('homestay.show', ['id' => $item->id]) }}">{{ strlen($item->name) > 20 ? substr($item->name, 0, 30) . '...' : $item->name }}</a>
                                    </h3>
                                    {{-- <p class="location mb-1"><span class="fa fa-map-marker mr-2"></span>{{ $item->lokasi }} --}}
                                    </p>
                                    <ul>
                                        <span data-feather="percent" style="width: 16px; color: rgb(86, 86, 86)"></span>
                                        <li style="color: rgb(86, 86, 86)">RP.
                                            {{ number_format($item->harga, 2, ',', '.') }}
                                            /orang</li>
                                    </ul>
                                    <ul>
                                        <li style="color: black">
                                            <a href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $item->notelp) }}"
                                                style="color: inherit; text-decoration: none;" target="_blank">
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
                                                @csrf --}}
                                            {{-- <input type="hidden" name="homestay_id" value="{{ $item->id }}"> --}}
                                            {{-- <a href="list-homestay/{{ $item->id }}/Form-WA"
                                                class="btn btn-primary rounded-2 btn-sm mt-2">Pesan Sekarang</a> --}}

                                            <a href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $item->notelp) }}"
                                                target="_blank" class="btn btn-primary rounded-2 btn-sm mt-2">Hubungi
                                                Sekarang</a>
                                            {{-- </form> --}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($homestays->lastPage() > 1)
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                            <ul>
                                @if ($homestays->onFirstPage())
                                    <li class="disabled"><span>&lt;</span></li>
                                @else
                                    <li><a href="{{ $homestays->previousPageUrl() }}">&lt;</a></li>
                                @endif

                                @foreach ($homestays->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $homestays->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @if ($homestays->hasMorePages())
                                    <li><a href="{{ $homestays->nextPageUrl() }}">&gt;</a></li>
                                @else
                                    <li class="disabled"><span>&gt;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endsection
