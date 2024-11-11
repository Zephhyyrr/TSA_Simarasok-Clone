@extends('frontend.layouts.main')

@section('content')
    <div class="hero-wrap hero-wrap-2 js-fullheight" style="position: relative;">
        <img src="/media/frontend/images/Home.jpg" alt="Background Image"
            style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: -1;">
        <div class="overlay"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: -1;">
        </div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="/">Home <i class="fa fa-chevron-right"></i></a></span>
                        <span>List Destinasi <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Daftar Destinasi</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <form action="/list-destinasi" method="GET" class="input-group">
            <div class="form-outline flex-grow-1" data-mdb-input-init>
                <input type="search" name="q" class="form-control" placeholder="Cari Destinasi"
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
                    <span class="subheading">Destinasi</span>
                    <h2 class="mb-4">Daftar Destinasi</h2>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($destinasis as $item)
                        <div class="col-md-4 ftco-animate">
                            <div class="project-wrap">
                                @if (count($item->media) > 0)
                                    <a href="{{ route('destinasi.show', ['id' => $item->id]) }}" class="img-wrapper">
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
                                            href="#">{{ strlen($item->name) > 20 ? substr($item->name, 0, 30) . '...' : $item->name }}</a>
                                    </h3>
                                    <p class="location mb-1 fs-12"><span class="fa fa-map-marker mr-2"><a
                                                href="{{ $item->lokasi }}" target="_blank"></span>Lihat Lokasi</a></p>
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
                                        <li style="color: black">
                                            <a href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $item->notelp) }}"
                                                style="color: inherit; text-decoration: none;">
                                                <span data-feather="phone-call" style="width: 16px"
                                                    class="mr-2"></span>{{ $item->notelp }}
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled d-flex justify-content-between">
                                        <li class="btn btn-outline rounded-2 btn-sm mt-2">
                                            <a href="{{ route('destinasi.show', ['id' => $item->id]) }}">Detail</a>
                                        </li>
                                        <li class="fs-12"">
                                            {{-- @if ($item->status == 'Normal')
                                                <i data-feather="circle" style="color: green;"></i> Normal --}}
                                            @if ($item->status == 'Perbaikan')
                                                <i data-feather="tool" style="width: 20px"></i> Perbaikan
                                            @elseif ($item->status == 'Tutup')
                                                <i data-feather="alert-circle" style="color: red; width: 20px"></i> Ditutup
                                            @endif
                                        </li>
                                        {{-- <li>
                                            <form method="POST" action="/booking-wisata">
                                                @csrf
                                                <input type="hidden" name="destinasi_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-primary rounded-2 btn-sm mt-2">Booking Destinasi</button>
                                            </form>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($destinasis->lastPage() > 1)
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                            <ul>
                                @if ($destinasis->onFirstPage())
                                    <li class="disabled"><span>&lt;</span></li>
                                @else
                                    <li><a href="{{ $destinasis->previousPageUrl() }}">&lt;</a></li>
                                @endif

                                @foreach ($destinasis->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $destinasis->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @if ($destinasis->hasMorePages())
                                    <li><a href="{{ $destinasis->nextPageUrl() }}">&gt;</a></li>
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
