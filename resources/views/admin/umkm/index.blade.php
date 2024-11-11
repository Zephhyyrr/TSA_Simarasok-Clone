@extends('admin.layout.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar UMKM</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <a href="/admin/umkm/create" class="btn btn-primary mb-3">Entri Data UMKM</a>
        </div>
        <div class="col-md-6">
            <form action="/admin/umkm" method="GET" class="input-group mb-3">
                <input type="text" class="form-control" name="q" value="{{ $q }}"
                    placeholder="cari sesuatu" aria-label="cari sesuatu">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>


    @if (session('success') || session('warning') || session('danger'))
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @else
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
    @endif

    <table class="table table-bordered table-striped table-responsive" style="max-width: 100%">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Owner</th>
            <th>No. Tel</th>
            <th>Aksi</th>
        </tr>
        @if ($umkms->isEmpty())
            <tr>
                <td style="text-align: center; background: rgb(187, 187, 187); color: rgb(41, 41, 41); font-weight: 600"
                    colspan="7">Data
                    not found.
                </td>
            </tr>
        @endif
        @foreach ($umkms as $item)
            <tr>
                <td>{{ $umkms->firstItem() + $loop->index }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->owner }}</td>
                <td>{{ $item->notelp }}</td>
                <td>
                    <form class="d-inline" action="/admin/produk" method="get">
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <button type="submit" class="btn btn-sm btn-success">Produk</button>
                    </form>
                    <form class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                        action="{{ route('umkm.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    <a href="/admin/umkm/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
        @endforeach

    </table>
    {{ $umkms->links() }}
@endsection
