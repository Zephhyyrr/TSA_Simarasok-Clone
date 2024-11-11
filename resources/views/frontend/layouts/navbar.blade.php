<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/admin">Simarasok<span>Desa Wisata Sumatera Barat</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="/" class="nav-link">Beranda</a>
                </li>
                <li class="nav-item {{ request()->is('list-post') || request()->is('list-hard-news*') || request()->is('list-soft-news*') || request()->is('list-feature*') ||  request()->is('list-post/*') ? 'active' : '' }}">
                    <a href="/list-post" class="nav-link">Berita</a>
                </li>
                <li class="nav-item {{ request()->is('list-destinasi') || request()->is('list-destinasi/*') ? 'active' : '' }}">
                    <a href="/list-destinasi" class="nav-link">Destinasi</a>
                </li>
                <li class="nav-item {{ request()->is('list-homestay') || request()->is('list-homestay/*') ? 'active' : '' }}">
                    <a href="/list-homestay" class="nav-link">Penginapan</a>
                </li>
                <li class="nav-item {{ request()->is('list-produk') || request()->is('produk/*') ? 'active' : '' }}">
                    <a href="/list-produk" class="nav-link">Oleh-Oleh</a>
                </li>
                <li class="nav-item {{ request()->is('list-video') || request()->is('video/*') ? 'active' : '' }}">
                    {{-- <a href="https://www.youtube.com/@pesonasimarasok2880" target="_blank" class="nav-link">Video</a> --}}
                    <a href="/list-video" class="nav-link">Video</a>
                </li>
                <li class="nav-item {{ request()->is('hubungi-kami') ? 'active' : ''}}">
                    <a href="/hubungi-kami" class="nav-link">Tentang Simarasok</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
