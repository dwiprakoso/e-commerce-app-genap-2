<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NearMe</title>
    <!-- SB Admin 2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Minimal custom CSS for admin theme */
        .bg-admin-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .bg-admin-image::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            content: "\f3ed";
            font-size: 8rem;
            color: rgba(255, 255, 255, 0.1);
        }

        .admin-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: inline-block;
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
                            <div class="col-lg-6 d-none d-lg-block bg-admin-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <div class="admin-badge">
                                            <i class="fas fa-shield-alt mr-2"></i>Administrator
                                        </div>
                                        <h1 class="h4 text-gray-900 mb-4">Login Administrator</h1>
                                        <p class="text-muted mb-4">Masuk ke panel administrasi</p>
                                    </div>

                                    <!-- Error Messages -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <div class="d-flex">
                                                <i class="fas fa-exclamation-circle mt-1 mr-2"></i>
                                                <div>
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Login Form -->
                                    <form method="POST" action="{{ route('admin.login') }}" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}"
                                                placeholder="Masukkan Email Administrator..." required
                                                autocomplete="email" autofocus>
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
                                                    id="password" name="password" placeholder="Password" required
                                                    autocomplete="current-password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button"
                                                        onclick="togglePassword()"
                                                        style="border-radius: 0 50px 50px 0; border-color: #d1d3e2;"
                                                        tabindex="-1">
                                                        <i id="passwordIcon" class="fas fa-eye"></i>
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
                                                <label class="custom-control-label" for="customCheck">Ingat saya</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Login sebagai Admin
                                        </button>
                                    </form>

                                    <hr>

                                    <!-- Security Notice -->
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        <strong>Area Terbatas:</strong> Hanya administrator yang memiliki akses ke panel
                                        ini.
                                    </div>

                                    <!-- Back to Home -->
                                    <div class="text-center mt-3">
                                        <a class="small text-muted" href="{{ route('member.home') }}">
                                            <i class="fas fa-arrow-left mr-1"></i>Kembali ke situs utama
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
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

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
