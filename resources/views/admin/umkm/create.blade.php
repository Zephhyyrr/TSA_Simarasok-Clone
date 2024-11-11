@extends('admin.layout.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Create UMKM</h1>
    </div>
    <div class="col-6">
        <a href="/admin/umkm" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/umkm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Owner</label>
                <input type="text" class="form-control @error('owner') is-invalid @enderror" name="owner"
                    value="{{ old('owner') }}">
                @error('owner')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">No. Telp</label>
                <input type="number" class="form-control @error('notelp') is-invalid @enderror" name="notelp"
                    value="{{ old('notelp') }}">
                @error('notelp')
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
