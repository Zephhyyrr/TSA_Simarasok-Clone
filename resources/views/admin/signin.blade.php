<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="/media/frontend/icons/favicon.png" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="/sign-in" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="/media/frontend/icons/favicon.png" width="40" alt="">
                                    <span class="fs-6" style="font-weight: bold; color: black">Simarasok</span>
                                </a>
                                <p class="text-center">Wonderful Indonesia</p>
                                <form action="{{ route('proses-signin') }}" method="POST" autocomplete="off">
                                    @csrf
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="floatingInput" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="floatingInput" name="email" placeholder="name@example.com"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="mb-4">
                                        <label for="floatingPassword" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="floatingPassword" placeholder="Password">
                                            <button type="button" class="btn btn-outline-primary" id="togglePassword">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <a href="{{ route('home') }}" class="text-primary fw-bold">Kembali</a>
                                        <span><a class="text-primary fw-bold" href="{{ route('password.request') }}">Lupa Password ?</a></span>
                                    </div>
                                    <button href="/admin" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2"
                                        type="submit">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/Password.js"></script>
</body>

</html>
