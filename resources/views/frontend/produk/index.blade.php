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
                        <span>List Oleh-Oleh <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Daftar Oleh-Oleh</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <form action="/list-produk" method="GET" class="input-group">
            <div class="form-outline flex-grow-1" data-mdb-input-init>
                <input type="search" name="q" class="form-control" placeholder="Cari Produk"
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
                    <h2 class="mb-4">Daftar Oleh-Oleh</h2>
                </div>
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($produks as $produk)
                        <div class="col-md-4 ftco-animate">
                            <div class="project-wrap">
                                @if (count($produk->media) > 0)
                                    <a href="{{ route('produk.show', ['id' => $produk->id]) }}" class="img-wrapper">
                                        <img src="{{ asset('media/' . $produk->media[0]->nama) }}"
                                            alt="{{ $produk->media[0]->nama }}" class="img">
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
                                        <a href="{{ route('produk.show', $produk->id) }}">
                                            {{ strlen($produk->name) > 20 ? substr($produk->name, 0, 30) . '...' : $produk->name }}
                                        </a>
                                    </h3>
                                    @if (is_null($produk->harga))
                                        <p> Disajikan pada {{ $produk->event }}</p>
                                    @else
                                        <p> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    @endif
                                    {{-- <p class="price">{{ $produk->harga }}</span></p> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($produks->lastPage() > 1)
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                            <ul>
                                @if ($produks->onFirstPage())
                                    <li class="disabled"><span>&lt;</span></li>
                                @else
                                    <li><a href="{{ $produks->previousPageUrl() }}">&lt;</a></li>
                                @endif
                                @foreach ($produks->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $produks->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @if ($produks->hasMorePages())
                                    <li><a href="{{ $produks->nextPageUrl() }}">&gt;</a></li>
                                @else
                                    <li class="disabled"><span>&gt;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
