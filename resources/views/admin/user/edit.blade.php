@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data {{ $users->name }}</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/user" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/users/{{ $users->id }}" method="post" enctype="multipart/form-data">
            @csrf @method('put')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $users->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', $users->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">New Password (Optional)</label>
                <input type="text" class="form-control @error('password') is-invalid @enderror" name="password"
                    value="{{ old('password') }}">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            {{-- <div class="mb-3">
                <label for="roles" class="form-label">Role</label>
                <select name="roles" class="form-control  @error('roles') is-invalid @enderror"">
                    <option>Pilih Role User</option>
                    <option value="admin" {{ old('roles',$users->roles)=='admin'? 'selected':'' }}>Admin</option>
                    <option value="owner_umkm" {{ old('roles',$users->roles)=='owner_umkm'? 'selected':'' }}>Owner UMKM</option>
                </select>
                @error('roles')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}
            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
            <div style="height: 25vh"></div>
        </form>
    </div>
@endsection
