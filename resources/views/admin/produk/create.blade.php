@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Oleh-Oleh Baru</h1>
</div>
@endsection

@section('content')
    <div class="col-6">
        <a id="kembali" class="btn btn-sm btn-warning mb-3">Kembali</a>
        <form action="/admin/produk" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" placeholder="ex. Keripik XXXX">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- hanya bisa memberikan 1 inputan --}}
                {{-- <div class="mb-3">
                    <label class="form-label" for="gambar">Media</label>
                    <input type="file" name="gambar[]" id="gambar" class="form-control @error('gambar') is-invalid @enderror" onchange="previewFiles(event)" accept="image/*" hidden>
                    <div id="preview-container"></div>
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
                    <script>
                        let currentFiles = [];
                        const previewFiles = (event) => {
                            const newFiles = Array.from(event.target.files);
                            currentFiles = currentFiles.concat(newFiles);
                            updatePreview();
                            updateFileInput(currentFiles);
                            document.getElementById('img-preview').style.display = 'none'; // Sembunyikan input setelah gambar dipilih
                        };

                        const updatePreview = () => {
                            const previewContainer = document.getElementById('preview-container');
                            previewContainer.innerHTML = '';

                            currentFiles.forEach((file, index) => {
                                const reader = new FileReader();
                                reader.onload = () => {
                                    let mediaElement;
                                    const previewWrapper = document.createElement('div');
                                    previewWrapper.style.position = 'relative';
                                    previewWrapper.style.display = 'inline-block';

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
                    </script>
                </div> --}}
            {{-- hanya bisa memberikan 1 inputan --}}

            <div class="mb-3">
                <label class="form-label" for="gambar">Media</label>
                <input type="file" name="gambar[]" id="gambar" class="form-control @error('gambar') is-invalid @enderror" onchange="previewFiles(event)" accept="image/*, video/*" hidden multiple>
                <div id="preview-container"></div>
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
                <script src="/js/InputMediaCreate.js"></script>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
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

            {{-- Penanganan Kategori --}}

                {{-- <script>
                        function handleCategoryChange(select) {
                            if (select.value === 'create_category') {
                                window.location.href = '/admin/produk/catcreate?umkm_id={{ $umkms->id }}'; // URL untuk fungsi catcreate
                            }
                        }
                    </script>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="" onchange="handleCategoryChange(this)">
                            <option value="">---Pilih Kategori---</option>
                            @foreach ($kategoris as $item)
                                <option value="{{ $item->id }}" @if (old('category_id') == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                            <option value="create_category">+ Tambah Kategori Baru</option>
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}

            {{-- Penanganan Kategori --}}

            <div class="mb-3">
                <label class="form-label">Penyediaan</label>

                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="hargaRadio" name="type" value="harga" {{ (old('type') == 'harga' || old('type') === null) ? 'checked' : '' }}>
                        <label class="form-check-label" for="hargaRadio">Dijual</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="eventRadio" name="type" value="event" {{ old('type') == 'event' ? 'checked' : '' }}>
                        <label class="form-check-label" for="eventRadio">Khusus</label>
                    </div>
                </div>
            </div>

            <div class="mb-3" id="hargaInput" style="display: none">
                <label class="form-label">Harga</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga"
                    value="{{ old('harga') }}" placeholder="Masukkan angka saja, tanpa titik dan sebagainya">
                @error('harga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3" id="eventInput" style="display: none">
                <label class="form-label">Event</label>
                <input type="text" class="form-control @error('event') is-invalid @enderror" name="event"
                    value="{{ old('event') }}" placeholder="Masukkan hari khusus">
                @error('event')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- <input type="hidden" name="umkm_id" value="{{ $umkms->id }}"> --}}

            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
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
