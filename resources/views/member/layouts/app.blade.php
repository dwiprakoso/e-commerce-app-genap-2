<!DOCTYPE html>
<html lang="id">

<head>
    <base href="{{ url('/') }}/" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NearMe - Jelajahi Keindahan Indonesia</title>

    <!-- Google Fonts (sesuai Travela) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap"
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Bootstrap CSS & Travela Custom CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- Stack untuk custom styles dari view -->
    @stack('styles')
    <style>
        /* Custom Styles untuk Travela Look */
        .hero-header {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('assets/img/carousel-2.jpg');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .section-title {
            position: relative;
            display: inline-block;
            color: #13357B;
        }

        .section-title::before {
            position: absolute;
            content: "";
            width: 45px;
            height: 2px;
            left: -50px;
            top: 50%;
            transform: translateY(-50%);
            background: #13357B;
        }

        .section-title::after {
            position: absolute;
            content: "";
            width: 45px;
            height: 2px;
            right: -50px;
            top: 50%;
            transform: translateY(-50%);
            background: #13357B;
        }

        .service-item {
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            transition: 0.5s;
        }

        .service-item:hover {
            box-shadow: 0 0 45px rgba(0, 0, 0, 0.08);
            border-color: #13357B;
        }

        .btn-primary {
            background: #13357B;
            border: #13357B;
        }

        .btn-primary:hover {
            background: #0f2a5a;
            border: #0f2a5a;
        }

        .btn-secondary {
            background: #FF6D03;
            border: #FF6D03;
        }

        .btn-secondary:hover {
            background: #e55a02;
            border: #e55a02;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.8));
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: end;
            padding: 20px;
        }

        .hero-btn {
            background: #FF6D03;
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .hero-btn:hover {
            background: #e55a02;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 109, 3, 0.3);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #13357B, #FF6D03);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .stats-counter {
            background: linear-gradient(135deg, #13357B, #FF6D03);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            color: white;
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #FF6D03;
        }
    </style>
</head>

<body>

    @include('member.components.sidebar')

    @yield('content')

    @include('member.components.footer')


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>

    <script>
        // Custom JavaScript untuk animasi dan interaksi
        $(document).ready(function() {
            // Spinner
            setTimeout(function() {
                $('#spinner').removeClass('show');
            }, 1);

            // Gallery hover effect
            $('.gallery-item').hover(function() {
                $(this).find('.gallery-overlay').fadeIn(300);
            }, function() {
                $(this).find('.gallery-overlay').fadeOut(300);
            });

            // Smooth scrolling
            $('a[href^="#"]').click(function(e) {
                e.preventDefault();
                var target = $($(this).attr('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });

            // Back to top button
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('.back-to-top').fadeIn('slow');
                } else {
                    $('.back-to-top').fadeOut('slow');
                }
            });

            $('.back-to-top').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 100, 'easeInOutExpo');
                return false;
            });

            // Newsletter subscription
            $('.newsletter button').click(function() {
                var email = $(this).siblings('input').val();
                if (email) {
                    alert('Terima kasih! Anda telah berlangganan newsletter kami.');
                    $(this).siblings('input').val('');
                } else {
                    alert('Silakan masukkan email Anda.');
                }
            });
        });

        // WOW Animation
        new WOW().init();
    </script>
    @stack('scripts')
</body>

</html>
