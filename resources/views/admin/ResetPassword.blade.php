<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link rel="shortcut icon" type="image/png" href="/media/frontend/icons/favicon.png" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
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
                                <form action="{{ route('password.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">New Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                id="newPassword" name="password" placeholder="New Password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                                id="confirmPassword" name="password_confirmation" placeholder="Confirm Password">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary w-100  p-2 fs-4 mb-4 rounded-2" type="submit">Reset Password</button>
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
</body>

</html>
