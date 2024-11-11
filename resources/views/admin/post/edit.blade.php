@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Berita "{{ $post->title }}"</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/post" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/post/{{ $post->id }}" method="post" enctype="multipart/form-data">
            @csrf @method('put')

            <input type="hidden" name="mediaToDelete" id="mediaToDelete">

            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                    value="{{ old('title', $post->title) }}">
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
                        <option value="{{ $item }}" @if (old('category', $post->category) == $item) selected @endif>
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
                <div id="preview-container">
                    <!-- Pratinjau media yang ada -->
                    @foreach($post->media as $media)
                    <div style="position: relative; display: inline-block;" data-media-id="{{ $media->id }}">
                        @if($media->tipe === 'gambar')
                        <img src="/media/{{ $media->nama }}" class="img-thumbnail" style="width: 300px; display: block;">
                        <button onclick="removeExistingMedia({{ $media->id }}, event)" style="position: absolute; top: 5px; right: 5px; background-color: rgba(255, 0, 0, 0.5); border: none; border-radius: 50%; cursor: pointer; width: 26px; height: 26px;">&#x2715;</button>
                        @elseif($media->tipe === 'video')
                        <video src="/media/{{ $media->nama }}" class="img-thumbnail" style="width: 300px; display: block;" controls></video>
                        <button onclick="removeExistingMedia({{ $media->id }}, event)" style="position: absolute; top: 5px; right: 5px; background-color: rgba(255, 0, 0, 0.5); border: none; border-radius: 50%; cursor: pointer; width: 26px; height: 26px;">&#x2715;</button>
                        @endif
                    </div>
                    @endforeach
                </div>
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
            </div>

            <script>
                let currentFiles = [];

                const previewFiles = (event) => {
                    const newFiles = Array.from(event.target.files);
                    currentFiles = currentFiles.concat(newFiles);
                    updatePreview();
                    updateFileInput(currentFiles);
                };

                const updatePreview = () => {
                    const previewContainer = document.getElementById('preview-container');

                    // Hapus pratinjau file yang baru ditambahkan saja (biarkan media yang ada tetap)
                    previewContainer.querySelectorAll('[data-new]').forEach(el => el.remove());

                    currentFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = () => {
                            let mediaElement;
                            const previewWrapper = document.createElement('div');
                            previewWrapper.style.position = 'relative';
                            previewWrapper.style.display = 'inline-block';
                            previewWrapper.dataset.new = true; // Menandai sebagai media baru

                            if (file.type.startsWith('image/')) {
                                mediaElement = document.createElement('img');
                                mediaElement.src = reader.result;
                            } else if (file.type.startsWith('video/')) {
                                mediaElement = document.createElement('video');
                                mediaElement.src = reader.result;
                                mediaElement.controls = true;
                            }

                            if (mediaElement) {
                                mediaElement.classList.add('img-thumbnail');
                                mediaElement.style.width = '300px';
                                mediaElement.style.display = 'block';

                                const removeButton = document.createElement('button');
                                removeButton.innerHTML = '&#x2715;';
                                removeButton.style.position = 'absolute';
                                removeButton.style.top = '5px';
                                removeButton.style.right = '5px';
                                removeButton.style.backgroundColor = 'rgba(255, 0, 0, 0.5)';
                                removeButton.style.width = '26px';
                                removeButton.style.height = '26px';
                                removeButton.style.border = 'none';
                                removeButton.style.borderRadius = '50%';
                                removeButton.style.cursor = 'pointer';
                                removeButton.addEventListener('click', () => {
                                    currentFiles = currentFiles.filter((_, i) => i !== index);
                                    updatePreview();
                                    updateFileInput(currentFiles);
                                });

                                previewWrapper.appendChild(mediaElement);
                                previewWrapper.appendChild(removeButton);
                                previewContainer.appendChild(previewWrapper);
                            }
                        }
                        reader.readAsDataURL(file);
                    });
                    updateYouTubeLinksPreview();
                };

                const updateFileInput = (updatedFiles) => {
                    const dataTransfer = new DataTransfer();
                    updatedFiles.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('gambar').files = dataTransfer.files;
                };

                const mediaToDelete = [];

                const removeExistingMedia = (id, event) => {
                    const mediaElement = document.querySelector(`[data-media-id='${id}']`);
                    mediaElement.remove();
                    mediaToDelete.push(id);

                    // Perbarui input tersembunyi dengan ID media yang dihapus
                    document.getElementById('mediaToDelete').value = JSON.stringify(mediaToDelete);

                    // Menghapus button yang ditekan
                    if (event && event.target) {
                        event.target.remove();
                    }

                    console.log(mediaToDelete);
                };

                // let currentFiles = [];
                let youtubeLinks = @json($post->youtubeLinks->pluck('nama')); // Ambil link YouTube dari post

                document.addEventListener("DOMContentLoaded", function() {
                    updateYouTubeLinksPreview();
                });

                const addYouTubeVideo = () => {
                    const link = document.getElementById('youtube-link').value;
                    if (link) {
                        youtubeLinks.push(link);
                        document.getElementById('youtube-links').value = JSON.stringify(youtubeLinks);
                        updateYouTubeLinksPreview();
                        document.getElementById('youtube-link').value = '';
                    }
                };

                const updateYouTubeLinksPreview = () => {
                    const previewContainer = document.getElementById('preview-container');

                    previewContainer.querySelectorAll('[data-youtube]').forEach(el => el.remove());

                    youtubeLinks.forEach((link, index) => {
                        const videoId = link.split('v=')[1] || link.split('/').pop();
                        const iframe = document.createElement('iframe');
                        iframe.width = '300';
                        iframe.height = '150';
                        iframe.src = `https://www.youtube.com/embed/${videoId}`;
                        iframe.frameBorder = '0';
                        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                        iframe.allowFullscreen = true;

                        const previewWrapper = document.createElement('div');
                        previewWrapper.style.position = 'relative';
                        previewWrapper.style.display = 'inline-block';
                        previewWrapper.dataset.youtube = true; // Menandai sebagai media baru

                        const removeButton = document.createElement('button');
                        removeButton.innerHTML = '&#x2715;';
                        removeButton.style.position = 'absolute';
                        removeButton.style.top = '5px';
                        removeButton.style.right = '5px';
                        removeButton.style.backgroundColor = 'rgba(255, 0, 0, 0.5)';
                        removeButton.style.width = '26px';
                        removeButton.style.height = '26px';
                        removeButton.style.border = 'none';
                        removeButton.style.borderRadius = '50%';
                        removeButton.style.cursor = 'pointer';
                        removeButton.addEventListener('click', () => {
                            youtubeLinks.splice(index, 1);
                            document.getElementById('youtube-links').value = JSON.stringify(youtubeLinks);
                            updateYouTubeLinksPreview();
                        });

                        previewWrapper.appendChild(iframe);
                        previewWrapper.appendChild(removeButton);
                        previewContainer.appendChild(previewWrapper);
                    });
                };

                const confirmDeleteMedia = () => {
                    mediaToDelete.forEach(id => {
                        fetch(`/media/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Media deleted successfully');
                            } else {
                                console.error('Failed to delete media');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    });
                };
            </script>

            <div class="mb-3">
                <label class="form-label">Konten</label>
                <div id="editor">
                    {!! old('content', $post->content) !!}
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
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" {{ $post->status == 'publish' ? 'checked' : '' }}>
                    <label class="form-check-label" for="status"> Publish</label>
                </div>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <input type="hidden" name="author_name" value="{{ auth()->user()->name }}">

            {{-- <button class="btn btn-sm btn-primary" type="submit" >Submit</button> --}}
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#details-modal">Lanjut</button>

            <div class="modal fade" id="details-modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bahasa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda ingin {{ $post->hasEn() ? 'mengubah':'menulis' }} berita dalam bahasa Inggris?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-warning" data-bs-target="#en-modal" data-bs-toggle="modal">Ya</button>
                            <button type="submit" onclick="confirmDeleteMedia()" class="btn btn-sm btn-primary">Tidak</button>
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
                                    value="{{ old('enTitle', $post->hasEn()==1?$post->en->title:'') }}">
                                @error('enTitle')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <div id="enEditor">
                                    {!! old('enContent', $post->hasEn()==1?$post->en->content:'') !!}
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
                            {{-- <button type="submit" onclick="confirmDeleteMedia()" class="btn btn-danger">Hapus</button> --}}
                            <button type="submit" onclick="confirmDeleteMedia()" class="btn btn-sm btn-warning">Cancel</button>
                            <button type="submit" onclick="confirmDeleteMedia()" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 25vh"></div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const cancelButton = document.querySelector('#en-modal .btn-warning');

            // Mendapatkan nilai default title dan content
            const defaultTitle = "{{ $post->hasEn()==1 ? $post->en->title : '' }}";
            const defaultContent = `{!! old('enContent', $post->hasEn()==1?$post->en->content:'') !!}`;

            // Menambahkan event listener pada tombol cancel
            cancelButton.addEventListener('click', function() {
                // Mengembalikan nilai input title dan content ke nilai default
                const enTitleInput = document.querySelector('input[name="enTitle"]');
                const enContentTextarea = document.querySelector('textarea[name="enContent"]');
                const enEditorDiv = document.querySelector('#enEditor');

                enTitleInput.value = defaultTitle;
                enContentTextarea.value = defaultContent;

                ClassicEditor
                    .create(enEditorDiv)
                    .then(editor => {
                        editor.setData(defaultContent);
                    })
                    .catch(error => {
                        console.error(error);
                    });

                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('en-modal'));
                modal.hide();
            });
        });

    </script>
@endsection
