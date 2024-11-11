@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar User</h1>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <a href="/admin/user/create" class="btn btn-primary mb-3">Tambahkan</a>
        </div>
        <div class="col-md-6">
            <form action="/admin/user" method="GET" class="input-group mb-3">
                <input type="text" class="form-control" name="query" value="{{ $q }}"
                    placeholder="Cari berdasarkan nama" aria-label="cari sesuatu">
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

    <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
        <table class="table table-bordered table-striped table-responsive" style="max-width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    {{-- <th>Alias</th>
                    <th>Roles</th> --}}
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center" style="background: rgb(187, 187, 187); color: rgb(41, 41, 41); font-weight: 600">
                            Data not found.
                        </td>
                    </tr>
                @else
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            {{-- <td>{{ $item->alias }}</td>
                            <td>{{ $item->roles }}</td> --}}
                            <td>
                                <a href="/updateStatus/{{$item->id}}" onclick="return confirm('Apakah anda ingin ganti status user?')">
                                    <span class="badge {{ $item->status == 'active' ? 'text-bg-success rounded-3' : 'text-bg-light rounded-3' }}" id="status">
                                        {{ $item->status  == 'active' ? 'Aktif' : 'Disable' }}
                                    </span>
                                </a>
                            </td>
                            <td>
                                <form class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                    action="{{ route('user.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                                <a href="/admin/user/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
@endsection
