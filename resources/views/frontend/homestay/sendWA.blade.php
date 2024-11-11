@extends('frontend.layouts.main')

@section('content')
<div class="hero-wrap hero-wrap-2 "
    style="background-image: url('{{ asset('media/' . $media) }}');height: 100px;">
        <div class="overlay" style="height: 100px;"></div>
    </div>
<div class="mt-3 page-wrapper p-t-130 p-b-100">
    <div class="wrapper wrapper--w680">
        <h1 class="text-center mb-2">{{ $nama }}</h1>
        <div class="card card-4 mb-6">
            <div class="card-body mb-6">
                <p>Click untuk melanjutkan pemesanan kamar pada {{ $nama }}</p>
                <a href="{{ $whatsappUrl }}" class="btn btn_primary" target="_blank">Kirim Pesan</a>
            </div>
        </div>
    </div>
</div>
@endsection
