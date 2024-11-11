@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Provider Baru</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/provider" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/provider" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Provider</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="">
                @error('name')
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
