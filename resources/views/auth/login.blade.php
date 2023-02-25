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

    <title>ESOL - Login</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/lib/remixicon/fonts/remixicon.css')}}">
    <link rel="stylesheet" href="{{asset('dashboard/lib/jqvmap/jqvmap.min.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/style.min.css')}}">
</head>

<body class="page-sign">

    <div class="card card-sign">
        <div class="card-header">
            <a href="#" class="header-logo mb-4">ESOL</a>
            <h3 class="card-title">Sign In</h3>
            <p class="card-text">Welcome back! Please signin to continue.</p>
        </div><!-- card-header -->
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label d-flex justify-content-between">{{ __('Password') }} <a href="{{ route('password.request') }}">Forgot password?</a></label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <!-- <input type="password" class="form-control" placeholder="Enter your password"> -->
                </div>
                <button type="submit" class="btn btn-primary btn-sign">
                    {{ __('Login') }}
                </button>
            </form>
            <!-- <button class="btn btn-primary btn-sign">Sign In</button> -->

            <div class="divider"><span>or sign in with</span></div>

            <div class="row gx-2">
                <div class="col"><button class="btn btn-facebook"><i class="ri-facebook-fill"></i> Facebook</button></div>
                <div class="col"><button class="btn btn-google"><i class="ri-google-fill"></i> Google</button></div>
            </div><!-- row -->
        </div><!-- card-body -->
        <div class="card-footer">
            Don't have an account? <a href="{{ route('register') }}">Create an Account</a>
        </div><!-- card-footer -->
    </div><!-- card -->

    <script src="{{asset('dashboard/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('dashboard/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- <script>
        'use script'

        var skinMode = localStorage.getItem('skin-mode');
        if (skinMode) {
            $('html').attr('data-skin', 'dark');
        }
    </script> -->


</body>

</html>
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->