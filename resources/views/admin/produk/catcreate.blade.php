@extends('admin.layout.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Create Kategori</h1>
    </div>
    <div class="col-6">
        <button id="kembali" class="btn btn-sm btn-warning mb-3">Kembali</button>
        <form action="/admin/produk/strcreate" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="hidden" name="umkm_id" value="{{ $umkm_id }}">
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
    <script>
        document.getElementById('kembali').addEventListener('click', function() {
            window.history.back();
        });
    </script>
@endsection
