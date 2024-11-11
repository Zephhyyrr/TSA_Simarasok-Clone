@extends('admin.layout.main')

@section('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    {{-- <h1 class="h2">Daftar Produk {{ $umkms->name }}</h1> --}}
    <h1 class="h2">Daftar Oleh-Oleh</h1>
</div>
@endsection

@section('content')
    {{-- <a onclick="kembali()" class="btn btn-sm btn-warning mb-3">Kembali</a> --}}

    <div class="row pt-3">
        <div class="col-md-6">
            {{-- <form action="/admin/produk/create" method="get">
                <input type="hidden" name="umkm_id" value="{{ $umkms->id }}">
                <button class="btn btn-primary mb-3" type="submit">Entri Data Produk</button>
            </form> --}}
            <a href="/admin/produk/create" class="btn btn-primary mb-3">Tambahkan</a>
        </div>
        <div class="col-md-6">
            <form action="/admin/produk" method="GET" class="input-group mb-3">
                <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="Cari berdasarkan nama" aria-label="cari sesuatu">
                {{-- <input type="hidden" class="form-control" name="id" value="{{ $umkms->id }}"> --}}
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

    <table class="table table-bordered table-striped table-responsive" style="max-width: 100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Harga / Event</th>
                <th>Kunjungan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($produks->isEmpty())
                <tr>
                    <td style="text-align: center; background: rgb(187, 187, 187); color: rgb(41, 41, 41); font-weight: 600" colspan="5">Data not found.</td>
                </tr>
            @endif
            @foreach ($produks as $item)
                <tr>
                    <td>{{ $produks->firstItem() + $loop->index }}</td>
                    <td>{{ $item->name }}</td>
                    {{-- <td>{{ $item->category->name }}</td> --}}
                    <td>
                        @if ( is_null($item->harga) )
                            {{ $item->event }}
                        @else
                            {{ 'Rp '.number_format($item->harga, 2, ',', '.') }}
                        @endif
                    </td>
                    <td>{{ $item->visits }}</td>
                    <td>
                        <form class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                            action="{{ route('produk.destroy', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        <a href="/admin/produk/{{ $item->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#details-modal" data-nama="{{ $item->name }}" data-desc="{{ $item->desc }}" data-harga="{{ $item->harga }}" data-event="{{ $item->event }}" data-gambar="{{ $item->media }}" {{-- data-category="{{ $item->category->name }}" --}} >Detail</button>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{ $produks->links() }}
    <!-- Modal -->
    <div class="modal fade" id="details-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" >
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"  id="nama-destinasi"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="media" class="mb-3"></div>
                    <div id="desc" class="mb-3"></div>
                    {{-- <p><strong>Kategori Produk:</strong> <span id="category"></span></p> --}}
                    <p><strong id="hargaOrEvent"></strong> <span id="harga-event"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const detailModal = document.getElementById('details-modal');
            detailModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;

                const namaDestinasi = detailModal.querySelector('#nama-destinasi');
                const deskripsi = detailModal.querySelector('#desc');
                const detailHargaEvent = detailModal.querySelector('#hargaOrEvent');
                const hargaEvent = detailModal.querySelector('#harga-event');
                const mediaContainer = detailModal.querySelector('#media');
                /* const category = detailModal.querySelector('#category'); */

                namaDestinasi.innerHTML = button.getAttribute('data-nama');
                deskripsi.innerHTML = button.getAttribute('data-desc');
                /* category.innerHTML = button.getAttribute('data-category'); */

                /* harga.innerHTML= parseFloat(button.getAttribute('data-harga')).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2
                    });
                // console.log(fharga);

                event.innerHTML= button.getAttribute('data-event'); */

                if (button.getAttribute('data-harga')) {

                    detailHargaEvent.innerHTML = 'Harga Produk:';

                    hargaEvent.innerHTML= parseFloat(button.getAttribute('data-harga')).toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2
                    });
                }
                else {

                    detailHargaEvent.innerHTML = 'Tersedia pada';

                    hargaEvent.innerHTML= button.getAttribute('data-event');
                }

                const objectMedia = JSON.parse(button.getAttribute('data-gambar'));
                // console.log(objectMedia);
                mediaContainer.innerHTML = '';
                objectMedia.forEach(item => {
                    // console.log(media);
                    var media;
                    if (item.tipe == 'gambar') {
                        media = document.createElement('img');
                    }else{
                        media = document.createElement('video');
                        media.setAttribute('controls', true);
                    }
                    media.classList.add('m-1');
                    media.style.height = '200px';
                    media.setAttribute('src', "/media/" + item.nama);
                    mediaContainer.appendChild(media);
                });
            });
        });
    </script>

    {{-- Fungsi untuk kembali --}}

        {{-- <script>
            function kembali() {
                window.history.back();
            }
        </script> --}}

    {{-- Fungsi untuk kembali --}}
@endsection
