<!DOCTYPE html>
<html lang="en">

<head>
    <title>Website Simarasok</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arizonia&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/FrontendAssets/css/animate.css">

    <link rel="stylesheet" href="/FrontendAssets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/FrontendAssets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/FrontendAssets/css/magnific-popup.css">

    <link rel="stylesheet" href="/FrontendAssets/css/bootstrap-datepicker.css">
    {{-- <link rel="stylesheet" href="css/jquery.timepicker.css"> --}}
    <link rel="icon" type="image/png" href="/media/frontend/icons/favicon.png">

    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/FrontendAssets/css/flaticon.css">
    <link rel="stylesheet" href="/FrontendAssets/css/style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.4.2/uicons-brands/css/uicons-brands.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

</head>

<body>
    <!--Navbar -->
    @include('frontend.layouts.navbar')
    <!-- END nav -->
    <main>
        {{-- @yield('header') --}}
        @yield('content')
    </main>

    <!--Footer -->
    @include('frontend.layouts.footer')
    <!--EndFooter -->
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>


    <script src="/FrontendAssets/js/jquery.min.js"></script>
    <script src="/FrontendAssets/js/jquery-migrate-3.0.1.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js"></script> --}}
    <script src="/FrontendAssets/js/popper.min.js"></script>
    <script src="/FrontendAssets/js/bootstrap.min.js"></script>
    <script src="/FrontendAssets/js/jquery.easing.1.3.js"></script>
    <script src="/FrontendAssets/js/jquery.waypoints.min.js"></script>
    <script src="/FrontendAssets/js/jquery.stellar.min.js"></script>
    <script src="/FrontendAssets/js/owl.carousel.min.js"></script>
    <script src="/FrontendAssets/js/jquery.magnific-popup.min.js"></script>
    <script src="/FrontendAssets/js/jquery.animateNumber.min.js"></script>
    <script src="/FrontendAssets/js/bootstrap-datepicker.js"></script>
    <script src="/FrontendAssets/js/scrollax.min.js"></script>
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> --}}
    {{-- <script src="/FrontendAssets/js/google-map.js"></script> --}}
    <script src="/FrontendAssets/js/main.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script>
        feather.replace({
            'aria-hidden': 'true'
        })
    </script>
</body>

</html>
