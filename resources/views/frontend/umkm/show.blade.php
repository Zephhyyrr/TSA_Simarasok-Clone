@extends('frontend.layouts.main')

@section('content')
    <div class="hero-wrap hero-wrap-2" style="height: 100px; background-color: rgb(0, 0, 0)">
        <div class="overlay" style="height: 100px; background-color: rgb(0, 0, 0); color: black"></div>
    </div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs">
                    <span><a href="/">Home</a></span>
                    <span><i class="fa fa-chevron-right"></i> <a href="/list-umkm">UMKM </a></span>
                    <span><i class="fa fa-chevron-right"></i> {{ $umkm->name }} </span>
                </p>
                <h1 class="mb-0 bread">{{ $umkm->name }}</h1>
            </div>
        </div>
    </div>
    </div>
    <div class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ftco-animate">
                    <p><strong>Pemilik:</strong> {{ $umkm->owner }}</p>
                    <p><strong>No. Telepon:</strong> <a
                            href="https://api.whatsapp.com/send?phone={{ str_replace('+', '', $umkm->notelp) }}">{{ $umkm->notelp }}</a>
                    </p>
                </div>
                <div class="col-md-6 ftco-animate">
                    <div class="container mt-3 mb-4">
                        <form action="/umkm/{{ $umkm->id }}" method="GET" class="input-group">
                            <div class="form-outline flex-grow-1" data-mdb-input-init>
                                <input type="search" name="q" class="form-control" placeholder="Cari Produk"
                                    value="{{ request('q') }}" />
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- <div class="row justify-content-center pb-2">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Produk</h2>
                </div>
            </div> --}}
            <div class="row">
                @foreach ($produk as $prdk)
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            @if (is_countable($prdk->media) && count($prdk->media) > 0)
                                <a href="{{ route('umkm.produk', ['id' => $prdk->id]) }}" class="img"
                                    style="background-image: url('{{ asset('media/' . $prdk->media[0]->nama) }}');"></a>
                            @else
                                <a href="{{ route('umkm.produk', ['id' => $prdk->id]) }}" class="img"
                                    style="background-color: #f8f9fa; align-items: center; justify-content: center; display: flex;">
                                    <span style="color: #6c757d; font-size: 18px; text-align: center">Tidak ada
                                        gambar</span>
                                </a>
                            @endif
                            <div class="text p-4">
                                <h3>
                                    <a href="{{ route('umkm.produk', ['id' => $prdk->id]) }}">
                                        {{ strlen($prdk->name) > 30 ? substr($prdk->name, 0, 30) . '...' : $prdk->name }}
                                    </a>
                                </h3>
                                <p style="color: rgb(0, 0, 0)">Rp {{ number_format($prdk->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
