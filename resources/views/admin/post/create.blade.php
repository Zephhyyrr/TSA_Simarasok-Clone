@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Berita Baru</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/post" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/post" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                    value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-control @error('category') is-invalid @enderror" id="">
                    @php
                        $kategoris = [
                            'Hard News',
                            'Soft News',
                            'Feature',
                        ];
                    @endphp
                    @foreach ($kategoris as $item)
                        <option value="{{ $item }}" @if (old('category') == $item) selected @endif>
                            {{ $item }}</option>
                    @endforeach
                </select>
                @error('category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

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
                <label class="form-label">Konten</label>
                <div id="editor">
                    {!! old('content') !!}
                </div>
                <textarea id="content" name="content" style="display:none;"></textarea>
                <script>
                    ClassicEditor
                        .create(document.querySelector('#editor'))
                        .then(editor => {
                            const isiBeritaTextarea = document.querySelector('#content');
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

            <div class="mb-3 ms-3">
                <div class="form-check form-switch @error('status') is-invalid @enderror">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                    <label class="form-check-label" for="status">Lansung Publish</label>
                </div>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <input type="hidden" name="author_name" value="{{ auth()->user()->name }}">

            {{-- <button class="btn btn-sm btn-primary" type="submit" >Submit</button> --}}
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#option">Lanjut</button>

            <div class="modal fade" id="option" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bahasa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda ingin menulis berita dalam bahasa Inggris?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-warning" data-bs-target="#en-modal" data-bs-toggle="modal">Ya</button>
                            <button type="submit" class="btn btn-sm btn-primary">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="en-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">English version</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control @error('enTitle') is-invalid @enderror" name="enTitle"
                                    value="{{ old('enTitle') }}">
                                @error('enTitle')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <div id="enEditor">
                                    {!! old('enContent') !!}
                                </div>
                                <textarea id="enContent" name="enContent" style="display:none;"></textarea>
                                <script>
                                    ClassicEditor
                                        .create(document.querySelector('#enEditor'))
                                        .then(editor => {
                                            const isiBeritaTextarea = document.querySelector('#enContent');
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
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 25vh"></div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
            const cancelButton = document.querySelector('#en-modal .btn-danger');

            cancelButton.addEventListener('click', function() {
                // Mendapatkan elemen input title dan content
                const enTitleInput = document.querySelector('input[name="enTitle"]');
                const enContentTextarea = document.querySelector('textarea[name="enContent"]');
                const enEditorDiv = document.querySelector('#enEditor');

                // Menghapus nilai dari input title dan content
                enTitleInput.value = '';
                enContentTextarea.value = '';

                // Mengosongkan editor ClassicEditor
                ClassicEditor
                    .create(enEditorDiv)
                    .then(editor => {
                        editor.setData('');
                    })
                    .catch(error => {
                        console.error(error);
                    });

                // Menutup modal secara manual
                const modal = bootstrap.Modal.getInstance(document.getElementById('en-modal'));
                modal.hide();
            });
        });
        </script>
    </div>
@endsection
