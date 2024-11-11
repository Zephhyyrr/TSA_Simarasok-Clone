@extends('frontend.layouts.main')

@section('content')
    <div class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('media/' . $produk->media[0]->nama) }}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span><a href="/">Home</a></span>
                        <span><i class="fa fa-chevron-right"></i> <a href="/list-umkm">UMKM </a></span>
                        <span><i class="fa fa-chevron-right"></i> <a href="{{ route('umkm.show', $produk->umkm->id) }}">{{ $produk->umkm->name }}</a></span>
                        <span><i class="fa fa-chevron-right"></i> {{ $produk->name }}</span>
                    </p>
                    <h1 class="mb-0 bread">{{ $produk->name }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 ftco-animate">
                    <img src="{{ asset('media/' . $produk->media[0]->nama) }}" class="img-fluid" alt="Gambar Produk">
                </div>
                <div class="col-md-6 ftco-animate">
                    <h2>{{ $produk->name }}</h2>
                    <p>{{ $produk->desc }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
