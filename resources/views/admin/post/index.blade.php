@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Berita</h1>
</div>
@endsection

@section('content')
    <div class="row pt-3">
        <div class="col-md-6">
            <a href="/admin/post/create" class="btn btn-primary mb-3">Tambahkan</a>
        </div>
        <div class="col-md-6">
            <form action="/admin/post" method="GET" class="input-group mb-3">
                <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                    placeholder="cari berdasarkan judul" aria-label="Cari berdasarkan judul">
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

    <table class="table table-bordered table-striped">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Kunjungan</th>
            <th>Aksi</th>
        </tr>
        @if ($posts->isEmpty())
            <tr>
                <td style="text-align: center; background: rgb(187, 187, 187); color: rgb(41, 41, 41); font-weight: 600"
                    colspan="7">Data
                    not found.
                </td>
            </tr>
        @endif
        @foreach ($posts as $item)
            <tr>
                <td>{{ $posts->firstItem() + $loop->index }}</td>
                <td>{{ $item->title }}</td>
                {{-- <td>{{ $item->category }}</td> --}}
                <td>
                    <form action="{{ route('post.toggleStatus', $item->id) }}" class="ms-3" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                id="toggleStatus{{ $item->id }}"
                                name="status"
                                {{ $item->status == 'publish' ? 'checked' : '' }}
                                onchange="this.form.submit()">
                            <label class="form-check-label" for="toggleStatus{{ $item->id }}">
                                {{ $item->status == 'publish' ? 'Publish' : 'Draft' }}
                            </label>
                        </div>
                    </form>
                </td>

                <td>{{ $item->visits }}</td>

                <td>
                    <form class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                        action="{{ route('post.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    <a href="/admin/post/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                    {{-- @dd($item->en, $item->id) --}}
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#details-modal"
                        data-nama="{{ $item->title }}"
                        data-slug="{{ $item->slug }}"
                        data-desc="{{ $item->content }}"
                        data-gambar="{{ $item->media }}"
                        data-category="{{ $item->category }}"
                        data-status="{{ $item->status }}"
                        data-hasEN="{{ $item->hasEn() }}"
                        data-titleEN="{{ $item->en ? $item->en->title : '' }}"
                        data-contentEN="{{ $item->en ? $item->en->content : '' }}"
                    >
                        Detail
                    </button>
                    @if ($item->hasEN()==1)
                    <form class="d-inline" onsubmit="return confirm('Yakin ingin menghapus versi bahasa Inggris data ini?')"
                        action="{{ route('postEN.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus Bahasa</button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>
    {{ $posts->links() }}

    <!-- Modal -->
    <div class="modal fade" id="details-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" >
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"  id="title"></h1><br>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-end mb-3">
                        <button id="btn-bahasa-id" class="btn btn-primary me-2">ID</button>
                        <button id="btn-bahasa-en" class="btn btn-outline-primary">EN</button>
                    </div>
                    <div id="media" class="mb-3"></div>
                    <p><strong id="category"></strong></p>
                    <div id="desc" class="mb-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const detailModal = document.getElementById('details-modal');
            detailModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;

                const namaDestinasi = detailModal.querySelector('#title');
                const deskripsi = detailModal.querySelector('#desc');
                const category = detailModal.querySelector('#category');
                const mediaContainer = detailModal.querySelector('#media');

                // Data untuk Bahasa Indonesia
                const titleID = button.getAttribute('data-nama');
                const descID = button.getAttribute('data-desc');

                // Data untuk Bahasa Inggris
                const hasEN = button.getAttribute('data-hasEN') == 1;
                const titleEN = button.getAttribute('data-titleEN');
                const descEN = button.getAttribute('data-contentEN');

                // Aseli cape bikin ini, bang
                // console.log(hasEN);
                // console.log(titleEN);
                // console.log(descEN);
                // Set data default ke Bahasa Indonesia
                namaDestinasi.innerHTML = titleID;
                deskripsi.innerHTML = descID;
                category.innerHTML = button.getAttribute('data-category');
                // slug.innerHTML = button.getAttribute('data-slug');

                const objectMedia = JSON.parse(button.getAttribute('data-gambar'));
                // console.log(objectMedia);
                mediaContainer.innerHTML = '';
                objectMedia.forEach(item => {
                    var media;
                    if (item.tipe == 'gambar') {
                        media = document.createElement('img');
                        media.setAttribute('src', "/media/" + item.nama);
                    }else if(item.tipe == 'video'){
                        media = document.createElement('video');
                        media.setAttribute('src', "/media/" + item.nama);
                        media.setAttribute('controls', true);
                    }else if(item.tipe == 'youtube'){
                        const videoId = item.nama.split('v=')[1] || item.nama.split('/').pop();
                        media = document.createElement('iframe');
                        media.src = `https://www.youtube.com/embed/${videoId}`;
                        media.frameBorder = '0';
                        media.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                        media.allowFullscreen = true;
                    }else{
                        console.log('Error pada media');
                    }
                    media.classList.add('m-1');
                    media.style.height = '200px';
                    mediaContainer.appendChild(media);
                });

                // // Handle toggle bahasa
                const btnBahasaID = detailModal.querySelector('#btn-bahasa-id');
                const btnBahasaEN = detailModal.querySelector('#btn-bahasa-en');

                if (hasEN != true) {
                    btnBahasaEN.style.display = 'none';
                    btnBahasaID.style.display = 'none';
                }
                btnBahasaID.addEventListener('click', () => {
                    namaDestinasi.innerHTML = titleID;
                    deskripsi.innerHTML = descID;
                    btnBahasaEN.classList.add('btn-outline-primary');
                    btnBahasaEN.classList.remove('btn-primary');
                    btnBahasaID.classList.add('btn-primary');
                    btnBahasaID.classList.remove('btn-outline-primary');
                });

                btnBahasaEN.addEventListener('click', () => {
                    namaDestinasi.innerHTML = titleEN;
                    deskripsi.innerHTML = descEN;
                    btnBahasaEN.classList.add('btn-primary');
                    btnBahasaEN.classList.remove('btn-outline-primary');
                    btnBahasaID.classList.add('btn-outline-primary');
                    btnBahasaID.classList.remove('btn-primary');
                });
            });
        });
    </script>
@endsection
