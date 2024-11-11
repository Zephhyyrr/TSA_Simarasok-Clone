@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Penginapan Baru</h1>
</div>    
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/homestay" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/homestay" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama penginapan</label>
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
                {{-- <div id="preview-youtube"></div> --}}
                <label class="form-label" for="gambar">
                    <div id="img-preview" class="img-thumbnail" style="width: 300px; height: 150px; display: flex; justify-content: center; align-items: center; cursor: pointer; background-color: aliceblue">
                        <i data-feather="plus" style="width: 100px; height: 100px;"></i>
                    </div>
                </label>
                {{-- <div class="input-group mb-3">
                    <input type="text" id="youtube-link" class="form-control" placeholder="Masukkan link YouTube">
                    <button class="btn btn-primary" type="button" onclick="addYouTubeVideo()">Tambahkan</button>
                </div>
                <input type="hidden" name="youtube_links" id="youtube-links"> --}}
                @error('gambar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <script src="/js/InputMediaCreate.js"></script>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi penginapan</label>
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
                <label class="form-label">Harga per malam</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                    value="{{ old('harga') }}" placeholder="Masukkan angka saja, tanpa titik dan sebagainya">
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contack person</label>
                <input type="text" class="form-control @error('notelp') is-invalid @enderror" name="notelp"
                    value="{{ old('notelp') }}" placeholder="ex: +628XXXXXXXXXX">
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
