<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Log In | {{$generalsetting->name}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{$generalsetting->meta_description}}" name="description" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}">

    <!-- Bootstrap css -->
    <link href="{{asset('public/backEnd/')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{asset('public/backEnd/')}}/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style"/>
    <!-- icons -->
    <link href="{{asset('public/backEnd/')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Head js -->
    <script src="{{asset('public/backEnd/')}}/assets/js/head.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body.authentication-bg-pattern {
            background: radial-gradient(circle at 10% 20%, rgb(239, 246, 255) 0%, rgb(219, 234, 254) 90%) !important;
            font-family: 'Outfit', sans-serif !important;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        body.authentication-bg-pattern::before {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #ff8b1a, #ff6700);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            filter: blur(100px);
            opacity: 0.15;
            z-index: 0;
        }

        body.authentication-bg-pattern::after {
            content: "";
            position: absolute;
            width: 450px;
            height: 450px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            border-radius: 50%;
            bottom: -150px;
            right: -150px;
            filter: blur(120px);
            opacity: 0.15;
            z-index: 0;
        }

        .account-pages {
            width: 100%;
            z-index: 10;
        }

        .card.bg-pattern {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06) !important;
            border-radius: 20px !important;
            overflow: hidden;
        }

        .auth-logo {
            display: block;
            margin-bottom: 25px;
        }

        .auth-logo img {
            max-height: 80px !important;
            max-width: 100% !important;
            width: auto !important;
            height: auto !important;
            filter: drop-shadow(0px 4px 6px rgba(0, 0, 0, 0.04));
            transition: transform 0.3s ease;
        }

        .auth-logo img:hover {
            transform: scale(1.04);
        }

        .login-title-desc {
            color: #6c757d;
            font-size: 14px;
            margin-top: 8px;
            font-weight: 400;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            font-size: 13.5px;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 10px !important;
            padding: 10px 15px;
            border: 1.5px solid #ced4da;
            background-color: rgba(255, 255, 255, 0.9);
            transition: all 0.25s ease;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #ff8b1a !important;
            box-shadow: 0 0 0 3px rgba(255, 139, 26, 0.15) !important;
            background-color: #fff;
        }

        .input-group-text {
            border-radius: 0 10px 10px 0 !important;
            background-color: rgba(255, 255, 255, 0.9) !important;
            border: 1.5px solid #ced4da;
            border-left: none;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .input-group:focus-within .input-group-text {
            border-color: #ff8b1a !important;
        }

        .input-group:focus-within .form-control {
            border-color: #ff8b1a !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff8b1a 0%, #ff6700 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 11px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(255, 103, 0, 0.2);
            transition: all 0.3s ease !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(255, 103, 0, 0.3);
            opacity: 0.95;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .form-check-input {
            border-radius: 5px !important;
            width: 17px;
            height: 17px;
            border: 1.5px solid #ced4da;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #ff8b1a !important;
            border-color: #ff8b1a !important;
        }

        .form-check-label {
            font-size: 14px;
            color: #6c757d;
            padding-left: 4px;
            cursor: pointer;
        }
        
        .welcome-heading {
            font-size: 22px;
            font-weight: 700;
            color: #343a40;
        }
    </style>
</head>
<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">
                            
                            <div class="text-center w-100 m-auto">
                                <div class="auth-logo">
                                    <a href="{{ url('/') }}" class="logo text-center">
                                        <img src="{{asset($generalsetting->white_logo)}}" alt="Logo">
                                    </a>
                                </div>
                                <h4 class="welcome-heading mt-3">Welcome Back!</h4>
                                <p class="login-title-desc mb-4">Enter your email address and password to access admin panel.</p>
                            </div>

                            <form method="POST" action="{{route('login')}}" >
                                @csrf
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input type="email" id="emailaddress" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" value="1" name="remember" checked>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="{{asset('public/backEnd/')}}/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="{{asset('public/backEnd/')}}/assets/js/app.min.js"></script>
    
</body>
</html>