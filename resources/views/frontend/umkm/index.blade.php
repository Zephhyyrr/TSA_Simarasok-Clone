@extends('frontend.layouts.main')

@section('content')
    <div class="hero-wrap hero-wrap-2 js-fullheight">
        <img src="/media/frontend/images/Home.jpg" alt="">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="/">Home <i class="fa fa-chevron-right"></i></a></span>
                        <span>UMKM <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">List UMKM</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <form action="/list-umkm" method="GET" class="input-group">
            <div class="form-outline flex-grow-1" data-mdb-input-init>
                <input type="search" name="q" class="form-control" placeholder="Cari UMKM" value="{{ request('q') }}"/>
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
                    <h2 class="mb-4">Daftar UMKM</h2>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach ($umkms as $item)
                    {{-- @dd($item->produk[0]->media) --}}
                        <div class="col-md-4 ftco-animate">
                            <div class="project-wrap">
                                @if ($item->firstProductImage())
                                    <a href="#" class="img"
                                        style="background-image: url('{{ asset('media/' . $item->firstProductImage()) }}');"></a>
                                @else
                                    <a href="#" class="img"
                                        style="background-color: #f8f9fa; align-items: center; justify-content: center; display: flex;">
                                        <span style="color: #6c757d; font-size: 18px; text-align: center">Tidak ada gambar</span>
                                    </a>
                                @endif
                                <div class="text p-4">
                                    <h3>
                                        <a href="#">
                                            {{ strlen($item->name) > 30 ? substr($item->name, 0, 30) . '...' : $item->name }}
                                        </a>
                                    </h3>
                                    <p class="location"><span class="fa fa-map-marker mr-2"></span>Lokasi</p>
                                    <ul>
                                        <li style="color: black">
                                            <a href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $item->notelp) }}"
                                                style="color: inherit; text-decoration: none;">
                                                <span data-feather="phone-call" style="width: 16px" class="mr-2"></span>{{ $item->notelp }}
                                            </a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li>
                                            <a href="{{ route('umkm.show', ['id' => $item->id]) }}" class="btn btn-primary rounded-2 btn-sm mt-2">Lihat Produk</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($umkms->lastPage() > 1)
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                            <ul>
                                @if ($umkms->onFirstPage())
                                    <li class="disabled"><span>&lt;</span></li>
                                @else
                                    <li><a href="{{ $umkms->previousPageUrl() }}">&lt;</a></li>
                                @endif

                                @foreach ($umkms->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $umkms->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @if ($umkms->hasMorePages())
                                    <li><a href="{{ $umkms->nextPageUrl() }}">&gt;</a></li>
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
