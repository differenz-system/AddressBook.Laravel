<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — {{ config('app.name', 'Address Book') }}</title>
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
                                    <i class="bi bi-person-plus fs-3 text-primary"></i>
                                </div>
                            </div>
                            <h3 class="text-center auth-title mb-1">Create account</h3>
                            <p class="text-center auth-subtitle mb-4">Join in to manage your professional address book.</p>

                            <form method="POST" action="{{ route('register.perform') }}" class="input-rounded">
                                @csrf
                                <div class="mb-2 input-group @error('name') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Full name" required autofocus>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback ms-1">{{ $message }}</div>
                                @enderror
                                <div class="mb-2 input-group @error('email') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback ms-1">{{ $message }}</div>
                                @enderror
                                <div class="mb-2 input-group @error('password') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback ms-1">{{ $message }}</div>
                                @enderror
                                <div class="mb-2 input-group @error('password_confirmation') has-error @enderror">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password" required>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback ms-1">{{ $message }}</div>
                                @enderror
                                <div class="d-grid mb-3">
                                    <button class="btn btn-gradient" type="submit">Create Account</button>
                                </div>
                            </form>
                            <div class="text-center mt-4">
                                <span class="small-muted">Already have an account?</span>
                                <a href="{{ route('login') }}" class="ms-1">Sign in</a>
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
