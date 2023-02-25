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
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('dashboard/img/favicon.png')}}">

    <title>ESOL - Page Expired</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/lib/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/lib/jqvmap/jqvmap.min.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/css/custom.css')}}">
</head>

<body class="page-error">

    <div class="header">
        <div class="container">
            <a href="{{route('home')}}" class="header-logo">ESOL</a>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 d-flex flex-column align-items-center">
                    <h1 class="error-number">419</h1>
                    <h2 class="error-title">Page Expired</h2>
                    <p class="error-text">Oopps. The page you were looking for is expired. Please Refresh and Retry.</p>
                    <a href="{{route('home')}}" class="btn btn-primary btn-error">Back to Home</a>
                </div><!-- col -->
                <div class="col-8 col-lg-6 mb-5 mb-lg-0">
                    <object type="image/svg+xml" data="{{asset('dashboard/img/404.svg')}}" class="w-100"></object>
                </div><!-- col -->
            </div><!-- row -->
        </div><!-- container -->
    </div><!-- content -->

    <script src="{{asset('dashboard/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('dashboard/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>