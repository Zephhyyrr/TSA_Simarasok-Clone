@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 mb-3 border-bottom">
    <h1 class="h2">Daftar Video</h1>
</div>
@endsection

@section('content')
<div class="row pt-3">
    <div class="col-md-6">
        <a href="/admin/video/create" class="btn btn-primary mb-3">Tambahkan</a>
    </div>
    <div class="col-md-6">
        <form action="/admin/video" method="GET" class="input-group mb-3">
            <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="Cari berdasarkan judul" aria-label="cari sesuatu">
            <button class="btn btn-outline-success" type="submit">Cari</button>
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

    <table class="table table-bordered table-striped table-responsive">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Lihat di youtube</th>
            <th>Highlight</th>
            <th>Aksi</th>
        </tr>
        @if ($videos->isEmpty())
            <tr>
                <td style="text-align: center; background: rgb(187, 187, 187); color: rgb(41, 41, 41); font-weight: 600" colspan="7">Data not found.</td>
            </tr>
        @endif
        @foreach ($videos as $item)
            <tr>
                <td>{{ $videos->firstItem() + $loop->index }}</td>
                <td>{{ $item->title }}</td>
                <td><a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a></td>
                <td>
                    <form action="{{ route('video.toggleHighlight', $item->id) }}" class="ms-3" method="POST">
                        @csrf @method('PUT')
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                id="toggleStatus{{ $item->id }}"
                                name="status"
                                {{ $item->highlight == 1 ? 'checked' : '' }}
                                onchange="this.form.submit()">
                        </div>
                    </form>
                </td>
                <td>
                    <form class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')" action="{{ route('video.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    <a href="/admin/video/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
        @endforeach

    </table>
    {{ $videos->links() }}
@endsection
