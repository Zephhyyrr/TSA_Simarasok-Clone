@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit {{ $produks->name }}</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <button id="kembali" class="btn btn-sm btn-warning mb-3">Kembali</button>
        <form action="/admin/produk/{{ $produks->id }}" method="post" enctype="multipart/form-data">
            @csrf @method('put')
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', $produks->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Penanganan 1 Media --}}

            {{-- <div class="mb-3">
                <label class="form-label" for="gambar">Media</label>
                <input type="file" name="gambar[]" id="gambar" class="form-control @error('gambar') is-invalid @enderror" onchange="previewFiles(event)" accept="image/*" hidden>
                <div id="preview-container">
                    <!-- Pratinjau media yang ada -->
                    @foreach($produks->media as $media)
                    <div id="lobak" style="position: relative; display: inline-block;" data-media-id="{{ $media->id }}">
                        @if($media->tipe === 'gambar')
                        <img src="/media/{{ $media->nama }}" class="img-thumbnail" style="width: 300px; display: block;">
                        @elseif($media->tipe === 'video')
                        <video src="/media/{{ $media->nama }}" class="img-thumbnail" style="width: 300px; display: block;" controls></video>
                        @endif
                        <button onclick="removeExistingMedia({{ $media->id }})" style="position: absolute; top: 5px; right: 5px; background-color: rgba(255, 255, 255, 0.8); border: none; border-radius: 50%; cursor: pointer;">&#x2715;</button>
                    </div>
                    @endforeach
                </div>
                <label class="form-label" for="gambar">
                    <div id="img-preview" class="img-thumbnail" style="width: 300px; height: 150px; display: flex; justify-content: center; align-items: center; cursor: pointer; background-color: aliceblue">
                        <i data-feather="plus" style="width: 100px; height: 100px;"></i>
                    </div>
                </label>
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
                    document.getElementById('img-preview').style.display = 'none';
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
                                    document.getElementById('img-preview').style.display = 'flex';
                                });

                                previewWrapper.appendChild(mediaElement);
                                previewWrapper.appendChild(removeButton);
                                previewContainer.appendChild(previewWrapper);
                            }
                        }
                        reader.readAsDataURL(file);
                    });
                };

                const updateFileInput = (updatedFiles) => {
                    const dataTransfer = new DataTransfer();
                    updatedFiles.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('gambar').files = dataTransfer.files;
                };

                const removeExistingMedia = (id) => {
                    const mediaElement = document.querySelector(`[data-media-id='${id}']`);
                    if (mediaElement) {
                        mediaElement.remove();
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
                    }
                    document.getElementById('img-preview').style.display = 'flex';
                };
            </script>
            <script>
                const lobak = document.getElementById('img-preview');
                const kocak = document.querySelectorAll('#lobak');
                lobak.style.display = (kocak.length > 0) ? 'none' : 'flex';
            </script> --}}

            {{-- Penanganan 1 Media --}}

            <div class="mb-3">
                <label class="form-label" for="gambar">Media</label>
                <input type="file" name="gambar[]" id="gambar" class="form-control @error('gambar') is-invalid @enderror" onchange="previewFiles(event)" accept="image/*, video/*" hidden multiple>
                <div id="preview-container">
                    <!-- Pratinjau media yang ada -->
                    @foreach($produks->media as $media)
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
                };

                const updateFileInput = (updatedFiles) => {
                    const dataTransfer = new DataTransfer();
                    updatedFiles.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('gambar').files = dataTransfer.files;
                };

                const mediaToDelete = [];

                const removeExistingMedia = (id, event) => {
                    const mediaElement = document.querySelector(`[data-media-id='${id}']`);
                    if (mediaElement) {
                        mediaElement.remove();
                        mediaToDelete.push(id); // Menggunakan push untuk menambahkan elemen ke array
                    }

                    // Menghapus button yang ditekan
                    if (event && event.target) {
                        event.target.remove();
                    }

                    console.log(mediaToDelete);
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
                    {!! old('desc', $produks->desc) !!}
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

            {{-- <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="">
                    @foreach ($kategoris as $item)
                        <option value="{{ $item->id }}" @if (old('category_id',$produks->category_id) == $item->id) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}

            <div class="mb-3">
                <label class="form-label">Penyediaan</label>
                <span class="text-danger"> (wajib dipilih)</span>

                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="hargaRadio" name="type" value="harga" {{ !empty($produks->harga) ? 'checked' : '' }}>
                        <label class="form-check-label" for="hargaRadio">Dijual</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="eventRadio" name="type" value="event" {{ !empty($produks->event) ? 'checked' : '' }}>
                        <label class="form-check-label" for="eventRadio">Khusus</label>
                    </div>
                </div>
            </div>

            <div class="mb-3" id="hargaInput" style="display: none">
                <label class="form-label">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                    value="{{ old('harga', $produks->harga) }}" placeholder="Masukkan angka saja, tanpa titik dan sebagainya">
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3" id="eventInput" style="display: none">
                <label class="form-label">Event</label>
                <input type="text" class="form-control @error('event') is-invalid @enderror" name="event"
                    value="{{ old('event', $produks->event) }}" placeholder="Masukkan hari khusus">
                @error('event')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- <input type="hidden" name="umkm_id" value="{{ $produks->umkm_id }}"> --}}

            <button class="btn btn-sm btn-primary" type="submit" onclick="confirmDeleteMedia()">Submit</button>
            <div style="height: 25vh"></div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil elemen radio buttons dan input fields
            var hargaRadio = document.getElementById('hargaRadio');
            var eventRadio = document.getElementById('eventRadio');
            var hargaInput = document.getElementById('hargaInput');
            var eventInput = document.getElementById('eventInput');

            // Fungsi untuk menampilkan input berdasarkan nilai radio yang dipilih
            function showInputBasedOnRadio() {
                if (hargaRadio.checked) {
                    hargaInput.style.display = 'block';
                    eventInput.style.display = 'none';

                    eventInput.querySelector('input').disabled = true; // Menambah atribut disabled pada input event
                    hargaInput.querySelector('input').disabled = false; // Menghapus atribut disabled pada input harga

                } else if (eventRadio.checked) {
                    hargaInput.style.display = 'none';
                    eventInput.style.display = 'block';

                    hargaInput.querySelector('input').disabled = true; // Menambah atribut disabled pada input harga
                    eventInput.querySelector('input').disabled = false; // Menghapus atribut disabled pada input event
                }
            }

            // Panggil fungsi saat halaman dimuat untuk menyesuaikan tampilan input
            showInputBasedOnRadio();

            // Tambahkan event listener pada radio buttons untuk perubahan
            hargaRadio.addEventListener('change', showInputBasedOnRadio);
            eventRadio.addEventListener('change', showInputBasedOnRadio);
        });

        document.getElementById('kembali').addEventListener('click', function() {
            window.history.back();
        });
    </script>
@endsection
