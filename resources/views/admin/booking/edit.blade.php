@extends('admin.layout.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Edit Berita</h1>
    </div>
    <div class="col-6">
        <a href="/admin/booking" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/booking/{{ $booking->id }}" method="post" enctype="multipart/form-data">
            @csrf @method('put')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $booking->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', $booking->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor telpon</label>
                <div class="input-group">
                    {{-- @dd($countryCode) --}}
                    <select name="country_code" class="form-control">
                        @foreach($countryCodes as $code => $country)
                        <option value="{{ $code }}" {{ old('country_code', $countryCode) == $code ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                        @endforeach
                    </select>
                    <input type="text" name="notelp" placeholder="nomor telpon" value="{{ old('notelp', $notelp) }}" class="form-control">
                </div>
                @error('notelp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Homestay</label>
                <select name="homestay_id" class="form-control @error('homestay_id') is-invalid @enderror" id="">
                    @foreach ($homestay as $item)
                        <option value="{{ $item->id }}" @if (old('homestay_id', $booking->homestay_id) == $item->id) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
                @error('homestay_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Durasi</label>
                <div class="form-group">
                    <input type="date" class="form-control @error('checkin') is-invalid @enderror" name="checkin" value="{{ old('checkin', $booking->checkin) }}">
                    <input type="date" class="form-control @error('checkout') is-invalid @enderror" name="checkout" value="{{ old('checkout', $booking->checkout) }}">
                </div>
                @error('checkin' || 'checkout')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
            <div style="height: 25vh"></div>
        </form>
    </div>
@endsection
