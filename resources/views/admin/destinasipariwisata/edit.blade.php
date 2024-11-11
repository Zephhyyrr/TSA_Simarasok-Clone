@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Destinasi {{ $destinasis->name }}</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a href="/admin/destinasipariwisata" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/destinasipariwisata/{{ $destinasis->id }}" method="post" enctype="multipart/form-data">
            @csrf @method('put')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $destinasis->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="gambar">Media</label>
                <input type="file" name="gambar[]" id="gambar" class="form-control @error('gambar') is-invalid @enderror" onchange="previewFiles(event)" accept="image/*, video/*" hidden multiple>
                <div id="preview-container">
                    <!-- Pratinjau media yang ada -->
                    @foreach($destinasis->media as $media)
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
                    
                    // Menghapus button yang ditekan
                    if (event && event.target) {
                        event.target.remove();
                    }
                    
                    console.log(mediaToDelete);
                };

                // let currentFiles = [];
                let youtubeLinks = @json($destinasis->youtubeLinks->pluck('nama')); // Ambil link YouTube dari post

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
                <label class="form-label">Deskripsi</label>
                <div id="editor">
                    {!! old('desc', $destinasis->desc) !!}
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
                    value="{{ old('harga', $destinasis->harga) }}">
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Contack person</label>
                <input type="text" class="form-control @error('notelp') is-invalid @enderror" name="notelp"
                    value="{{ old('notelp', $destinasis->notelp) }}" placeholder="ex: +628XXXXXXXXXX">
                @error('notelp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Link lokasi</label>
                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                    value="{{ old('lokasi', $destinasis->lokasi) }}">
                @error('lokasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Status Destinasi</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="normal" {{ old('status', $destinasis->status) == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="perbaikan" {{ old('status', $destinasis->status) == 'perbaikan' ? 'selected' : '' }}>Sedang Perbaikan</option>
                    <option value="ditutup" {{ old('status', $destinasis->status) == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
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
                <div class="input-group row">
                    <label class="form-label col-4">{{ $item->name }}</label>
                    <select class="form-select col-8 @error('providers[]') is-invalid @enderror" name="providers[]">
                        <option value="Belum Diketahui" selected>Belum diketahui</option>
                        <option value="Very Good" {{ old('status', isset( $destinasis->provider[$loop->index]->signal)?$destinasis->provider[$loop->index]->signal:'') == 'Very Good' ? 'selected' : '' }}>Very Good</option>
                        <option value="Good" {{ old('status', isset( $destinasis->provider[$loop->index]->signal)?$destinasis->provider[$loop->index]->signal:'') == 'Good' ? 'selected' : '' }}>Good</option>
                        <option value="Normal" {{ old('status', isset( $destinasis->provider[$loop->index]->signal)?$destinasis->provider[$loop->index]->signal:'') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Fair" {{ old('status', isset( $destinasis->provider[$loop->index]->signal)?$destinasis->provider[$loop->index]->signal:'') == 'Fair' ? 'selected' : '' }}>Fair</option>
                        <option value="Bad" {{ old('status', isset( $destinasis->provider[$loop->index]->signal)?$destinasis->provider[$loop->index]->signal:'') == 'Bad' ? 'selected' : '' }}>Bad</option>
                    </select>
                </div>
                @endforeach
                @error('providers[]')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button class="btn btn-sm btn-primary" type="submit" onclick="confirmDeleteMedia()">Submit</button>

            <div style="height: 25vh"></div>
        </form>
    </div>
@endsection
