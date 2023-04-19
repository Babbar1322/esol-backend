<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author" content="Webcyst">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboard/img/favicon.png') }}">

    <title>ESOL - Dashboard</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/lib/remixicon/fonts/remixicon.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/custom.css') }}">

    <style>
        .fadeInUp {
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(4rem);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body.modal-open .modal {
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
        }
    </style>
</head>

<body>

    @include('components.sidebar')

    @include('components.header')

    <div class="main main-app p-3 p-lg-4">
        @yield('content')

        <div class="main-footer mt-5">
            <span>&copy; 2023. English School Of Language. All Rights Reserved.</span>
        </div><!-- main-footer -->
    </div><!-- main -->


    <script src="{{ asset('dashboard/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dashboard/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('dashboard/lib/jquery.flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('dashboard/lib/jquery.flot/jquery.flot.resize.js') }}"></script>

    <script src="{{ asset('dashboard/js/script.js') }}"></script>
    <script src="{{ asset('dashboard/js/db.data.js') }}"></script>
    <script src="{{ asset('dashboard/js/db.analytics.js') }}"></script>

</body>

</html>