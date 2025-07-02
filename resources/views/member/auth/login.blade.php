<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NearMe</title>
    <!-- SB Admin 2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Minimal custom CSS - only for tourism theme branding */
        /* .bg-login-image {
            background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1000 600%22><rect fill=%22%234e73df%22 width=%221000%22 height=%22600%22/><g><circle cx=%22200%22 cy=%22150%22 r=%2240%22 fill=%22%23ffd700%22/><polygon points=%22300,400 350,320 400,400%22 fill=%22%2328a745%22/><polygon points=%22500,350 550,250 600,350%22 fill=%22%2328a745%22/><polygon points=%22700,380 750,280 800,380%22 fill=%22%2328a745%22/><rect x=%22100%22 y=%22450%22 width=%22800%22 height=%22100%22 fill=%22%2317a2b8%22/><text x=%22500%22 y=%22520%22 font-family=%22Arial%22 font-size=%2236%22 fill=%22white%22 text-anchor=%22middle%22>🏔️ NearMe</text></g></svg>') center/cover;
        } */

        /* Custom button styling following SB Admin 2 patterns */
        .btn-google {
            color: #5a5c69;
            background-color: #fff;
            border-color: #dddfeb;
        }

        .btn-google:hover {
            color: #3a3b45;
            background-color: #f8f9fc;
            border-color: #b7b9cc;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                                    </div>

                                    <!-- Social Login Buttons -->
                                    <div class="mb-3">
                                        <a href="{{ route('member.social.redirect', 'google') }}"
                                            class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Masuk dengan Google
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <a href="{{ route('member.social.redirect', 'facebook') }}"
                                            class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Masuk dengan Facebook
                                        </a>
                                    </div>

                                    <hr>

                                    <!-- Error Messages -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Login Form -->
                                    <form method="POST" action="{{ route('member.login.post') }}" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="exampleInputEmail" name="email" value="{{ old('email') }}"
                                                placeholder="Masukkan Alamat Email..." required autocomplete="email"
                                                autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control form-control-user @error('password') is-invalid @enderror"
                                                    id="exampleInputPassword" name="password" placeholder="Password"
                                                    required autocomplete="current-password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword()"
                                                        style="border-radius: 0 50px 50px 0; border-color: #d1d3e2;"
                                                        tabindex="-1">
                                                        <i id="passwordToggleIcon" class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-sign-in-alt fa-sm"></i> Masuk
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('member.register') }}">Buat Akun Baru!</a>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a class="small text-muted" href="{{ route('member.home') }}">
                                            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('exampleInputPassword');
            const passwordIcon = document.getElementById('passwordToggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>

</html>
