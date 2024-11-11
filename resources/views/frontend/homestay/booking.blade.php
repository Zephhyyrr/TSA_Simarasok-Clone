@extends('frontend.layouts.main')

@section('content')
<link rel="stylesheet" href="/css/BookingHomestay.css">
    <div class="hero-wrap hero-wrap-2 "
    style="background-image: url('{{ asset('media/' . $homestay->media[0]->nama) }}');height: 100px;">
        <div class="overlay" style="height: 100px;"></div>
    </div>
    <div class="mt-3 page-wrapper p-t-130 p-b-100">
        <div class="wrapper wrapper--w680">
            <h1 class="text-center mb-2">{{ $homestay->name }}</h1>
            <div class="card card-4 mb-6">
                <div class="card-body mb-6">
                    <h2 class="title">Booking {{ $homestay->name }}</h2>
                    <form action="/booking/send" method="POST" class="">
                        @csrf @method('put')
                        <div class="row row-space">
                            <div class="col-12">
                                <div class="input-group">
                                    <label class="label">Nama Pemesan</label>
                                    <input class="input--style-4" type="text" name="name" placeholder="Nama pemesan" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-12">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" type="email" name="email" placeholder="alamat email aktif" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-12">
                                <div class="input-group">
                                    <label class="label">Nomor Telepon</label>
                                    <div class="input-group">
                                        <select name="country_code" class="input--style-4" style="width: 30%;">
                                            @foreach($countryCodes as $code => $country)
                                                <option value="{{ $code }}" {{ old('country_code', '+62') == $code ? 'selected' : '' }}>
                                                    {{ $country }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input class="input--style-4" type="text" name="notelp" placeholder="nomor telpon" value="{{ old('notelp') }}" style="width: 70%;">
                                        @error('notelp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-6">
                                <div class="input-group">
                                    <label class="label">Check-in</label>
                                    <input class="input--style-4 js-datepicker" type="date" name="checkin" value="{{ old('checkin') }}">
                                    @error('checkin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group">
                                    <label class="label">Check-out</label>
                                    <input class="input--style-4 js-datepicker" type="date" name="checkout" value="{{ old('checkout') }}">
                                    @error('checkout')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="homestay_id" value="{{ $homestay->id }}">
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn btn-primary" type="submit">Booking now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <script src="/js/BookingHomestay.js"></script>
    @endsection
