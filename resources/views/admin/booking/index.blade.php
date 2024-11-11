@extends('admin.layout.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Booking</h1> {{-- Perbaiki minor --}}
    </div>
    <div class="row">
        <div class="col-md-6">
            <a href="/admin/booking/create" class="btn btn-primary mb-3">Booking</a>
        </div>
        <div class="col-md-6">

            {{-- Seperti sebelumnya lagi, Button ubah jadi Search dan name inputan diganti jadi q --}}
            <form action="/admin/booking" method="GET" class="input-group mb-3">
                <input type="text" class="form-control" name="q" value="{{ $q }}"
                    placeholder="cari sesuatu" aria-label="cari sesuatu">
                <button class="btn btn-outline-success" type="submit">Search</button>
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
            <th>Nama</th>
            <th>notelp</th>
            <th>homestay</th>
            <th>Status</th>
            <th>action</th>
        </tr>
        @if ($booking->isEmpty())
            <tr>
                <td style="text-align: center; background: rgb(187, 187, 187); color: rgb(41, 41, 41); font-weight: 600"
                    colspan="7">Data
                    not found.
                </td>
            </tr>
        @endif
        @foreach ($booking as $item)
            <tr>
                <td>{{ $booking->firstItem() + $loop->index }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->notelp }}</td>
                <td>{{ $item->homestay->name }}</td>
                <td>
                    <a href="/admin/booking/{{$item->id}}/approve" onclick="return confirm('{{$item->status=='approved'?'Cancel':'Approve'}} {{ $item->name }}?')">
                        <span class="badge {{ $item->status=='approved'?'text-bg-success':($item->status=='canceled'?'text-bg-danger':'text-bg-light') }} rounded-3" id="status">
                            {{ $item->status}}
                        </span>
                    </a>
                </td>
                <td>
                    <form class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                        action="{{ route('booking.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    <a href="/admin/booking/{{ $item->id }}/edit" class="btn btn-sm btn-warning d-inline">Edit</a>
                    <button class="btn btn-sm btn-primary d-inline" data-bs-toggle="modal" data-bs-target="#details-modal"
                        data-nama="{{ $item->name }}" data-email="{{ $item->email }}" data-notelp="{{ $item->notelp }}"
                        data-checkin="{{ $item->checkin }}" data-checkout="{{ $item->checkout }}" data-status="{{ $item->status }}"
                        data-homestay="{{ $item->homestay->name }}" data-id="{{ $item->id }}">Detail</button>
                </td>
            </tr>
        @endforeach
    </table>

    <!-- Modal -->
    <div class="modal fade" id="details-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"  id="nama-homestay"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td> : </td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> : </td>
                            <td id="email"></td>
                        </tr>
                        <tr>
                            <td>Notelp</td>
                            <td> : </td>
                            <td id="notelp"></td>
                        </tr>
                        <tr>
                            <td>Dari</td>
                            <td> : </td>
                            <td id="checkin"></td>
                        </tr>
                        <tr>
                            <td>Sampai</td>
                            <td> : </td>
                            <td id="checkout"></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td> : </td>
                            <td id="status"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const detailModal = document.getElementById('details-modal');
            detailModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;

                const namaHomestay = detailModal.querySelector('#nama-homestay');
                const nama = detailModal.querySelector('#name');
                const email = detailModal.querySelector('#email');
                const notelp = detailModal.querySelector('#notelp');
                const checkin = detailModal.querySelector('#checkin');
                const checkout = detailModal.querySelector('#checkout');
                const status = detailModal.querySelector('#status');

                namaHomestay.innerHTML = button.getAttribute('data-homestay');
                nama.innerHTML = button.getAttribute('data-nama');
                email.innerHTML = button.getAttribute('data-email');
                notelp.innerHTML = button.getAttribute('data-notelp');
                checkin.innerHTML = button.getAttribute('data-checkin');
                checkout.innerHTML = button.getAttribute('data-checkout');
                status.innerHTML = button.getAttribute('data-status');
            });
        });
    </script>

    {{ $booking->links() }}
@endsection
