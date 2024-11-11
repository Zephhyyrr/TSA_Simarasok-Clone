@extends('frontend.layouts.main')

@section('content')
    <div class="hero-wrap hero-wrap-2" style="background-color: black; color: black; height: 100px;">
        <div class="overlay" style="height: 100px;"></div>
    </div>
    <div class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-2">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Form Pemesanan</h2>
                    <strong>{{ $homestay->name }}</strong>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3"></div>
                <div class="ftco-animate col-lg-6" style="">
                    <form action="/sendWA" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 mt-4">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan nama anda">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="number" class="form-control" name="target" placeholder="Masukkan nomor yang akan dihubungi ex.08xxxx">
                        </div>
                        <input type="hidden" name="pemilik" value={{ $homestay->notelp }}>
                        <input type="hidden" name="homestay" value="{{ $homestay->name }}">
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
