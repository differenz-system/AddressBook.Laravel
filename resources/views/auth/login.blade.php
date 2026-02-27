<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — {{ config('app.name', 'Address Book') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body class="auth-bg">
    <div class="auth-scene">
        <div class="orb o1"></div>
        <div class="orb o2"></div>
        <div class="orb o3"></div>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-10 col-md-7 col-lg-5" data-aos="zoom-in" data-aos-duration="700">
                    <div class="auth-card shadow-lg border-0 mx-auto">
                        <div class="p-4 p-md-5">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="icon-badge">
                                    <i class="bi bi-box-arrow-in-right fs-3 text-primary"></i>
                                </div>
                            </div>
                            <h3 class="text-center auth-title mb-1">Sign in</h3>
                            <p class="text-center auth-subtitle mb-4">Welcome back. Access your contacts quickly and securely.</p>

                            <form method="POST" action="{{ route('login.perform') }}" class="input-rounded">
                                @csrf
                                @error('email')
                                    <div class="invalid-feedback ms-1 text-center">{{ $message }}</div>
                                @enderror
                                <div class="mb-2 input-group @error('email') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required autofocus>
                                </div>
                                <div class="mb-2 input-group @error('password') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                        <label for="remember" class="form-check-label">Remember me</label>
                                    </div>
                                </div>
                                <div class="d-grid mb-3">
                                    <button class="btn btn-gradient" type="submit">Get Started</button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <span class="small-muted">Don’t have an account?</span>
                                <a href="{{ route('register.show') }}" class="ms-1">Create one</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true
        });
    </script>
</body>

</html>
