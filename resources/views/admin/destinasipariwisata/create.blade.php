@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Destinasi Pariwisata Baru</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/destinasipariwisata" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/destinasipariwisata" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lokasi</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" placeholder="ex. Air terjun XXXX">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="gambar">Media</label>
                <input type="file" name="gambar[]" id="gambar" class="form-control @error('gambar') is-invalid @enderror" onchange="previewFiles(event)" accept="image/*, video/*" hidden multiple>
                <div id="preview-container"></div>
                <div id="preview-youtube"></div>
                <label class="form-label" for="gambar">
                    <div id="img-preview" class="img-thumbnail" style="width: 300px; height: 150px; display: flex; justify-content: center; align-items: center; cursor: pointer; background-color: aliceblue">
                        <i data-feather="plus" style="width: 100px; height: 100px;"></i>
                    </div>
                </label>
                <div class="input-group mb-3">
                    <input type="text" id="youtube-link" class="form-control" placeholder="Masukkan link YouTube">
                    <button class="btn btn-primary" type="button" onclick="addYouTubeVideo()">Tambahkan</button>
                </div>
                <input type="hidden" name="youtube_links" id="youtube-links">
                @error('gambar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <script src="/js/InputMediaCreate.js"></script>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi destinasi</label>
                <div id="editor">
                    {!! old('desc') !!}
                </div>
                <textarea id="desc" name="desc" style="display:none;"></textarea>
                <script>
                    ClassicEditor
                        .create(document.querySelector('#editor'))
                        .then(editor => {
                            const isiBeritaTextarea = document.querySelector('#desc');
                            editor.model.document.on('change:data', () => {
                                isiBeritaTextarea.value = editor.getData();
                            });
                            const form = isiBeritaTextarea.closest('form');
                            form.addEventListener('submit', () => {
                                isiBeritaTextarea.value = editor.getData();
                            });
                        })
                        .catch(error => {
                            console.error(error);
                        });
                </script>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Tiket</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                    value="{{ old('harga') }}" placeholder="Masukkan angka saja, tanpa titik dan sebagainya">
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contact person</label>
                <input type="text" class="form-control @error('notelp') is-invalid @enderror" name="notelp"
                    value="{{ old('notelp') }}" placeholder="ex: +628XXXXXXXXXX">
                @error('notelp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Link lokasi</label>
                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                    value="{{ old('lokasi') }}">
                @error('lokasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status Destinasi</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="normal" {{ old('status') == 'normal' ? 'selected' : '' }} selected>Normal</option>
                    <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Sedang Perbaikan</option>
                    <option value="ditutup" {{ old('status') == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kecepatan Internet</label>
                @foreach ($providers as $item)
                    <div class="input-group row mb-1">
                        <label class="form-label col-4">{{ $item->name }}</label>
                        <select class="form-select col-8 @error('providers') is-invalid @enderror" name="providers[]">
                            <option value="Belum diketahui" selected>Belum diketahui</option>
                            <option value="Very Good" {{ old('providers.' . $loop->index) == 'Very Good' ? 'selected' : '' }}>Very Good</option>
                            <option value="Good" {{ old('providers.' . $loop->index) == 'Good' ? 'selected' : '' }}>Good</option>
                            <option value="Normal" {{ old('providers.' . $loop->index) == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Fair" {{ old('providers.' . $loop->index) == 'Fair' ? 'selected' : '' }}>Fair</option>
                            <option value="Bad" {{ old('providers.' . $loop->index) == 'Bad' ? 'selected' : '' }}>Bad</option>
                        </select>
                    </div>
                @endforeach
                @error('providers')
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
