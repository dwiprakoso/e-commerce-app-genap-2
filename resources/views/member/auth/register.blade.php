<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - NearMe</title>
    <!-- SB Admin 2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Minimal custom CSS - consistent with login page */
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

        .password-strength {
            font-size: 0.75rem;
        }

        .password-strength .check-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        .password-strength .check-item i {
            width: 16px;
            margin-right: 0.5rem;
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
                                        <h1 class="h4 text-gray-900 mb-4">Bergabung Bersama Kami!</h1>
                                        <p class="text-muted small mb-4">Buat akun untuk memulai petualangan Anda</p>
                                    </div>

                                    <!-- Social Login Buttons -->
                                    <div class="mb-3">
                                        <a href="{{ route('member.social.redirect', 'google') }}"
                                            class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Daftar dengan Google
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <a href="{{ route('member.social.redirect', 'facebook') }}"
                                            class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Daftar dengan Facebook
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

                                    <!-- Register Form -->
                                    <form method="POST" action="{{ route('member.register.post') }}" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="name"
                                                name="name" value="{{ old('name') }}" placeholder="Nama Lengkap"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email"
                                                name="email" value="{{ old('email') }}" placeholder="Alamat Email"
                                                required>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <div class="input-group">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="password" name="password" placeholder="Password" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="togglePassword('password', 'passwordIcon')"
                                                            style="border-radius: 0 50px 50px 0; border-color: #d1d3e2;"
                                                            tabindex="-1">
                                                            <i id="passwordIcon" class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="password-strength mt-2">
                                                    <div class="check-item" id="length-check">
                                                        <i class="fas fa-times text-danger"></i>
                                                        <span class="text-muted">Min. 8 karakter</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="password_confirmation" name="password_confirmation"
                                                        placeholder="Ulangi Password" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            onclick="togglePassword('password_confirmation', 'confirmPasswordIcon')"
                                                            style="border-radius: 0 50px 50px 0; border-color: #d1d3e2;"
                                                            tabindex="-1">
                                                            <i id="confirmPasswordIcon" class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="terms"
                                                    required>
                                                <label class="custom-control-label" for="terms">
                                                    Saya menyetujui
                                                    <a href="#" class="text-primary">Syarat & Ketentuan</a>
                                                    dan
                                                    <a href="#" class="text-primary">Kebijakan Privasi</a>
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-user-plus fa-sm"></i> Daftar Akun
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <span class="small text-muted">Sudah punya akun? </span>
                                        <a class="small" href="{{ route('member.login') }}">Masuk sekarang!</a>
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
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);

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

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const lengthCheck = document.getElementById('length-check');
            const icon = lengthCheck.querySelector('i');
            const span = lengthCheck.querySelector('span');

            if (password.length >= 8) {
                icon.className = 'fas fa-check text-success';
                span.className = 'text-success';
            } else {
                icon.className = 'fas fa-times text-danger';
                span.className = 'text-muted';
            }
        });

        // Auto-hide alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>

</html>
