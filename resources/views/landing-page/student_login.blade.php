<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - School Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">

  <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">
  <style>
    .inp-style{
      padding: 14px 20px !important;
      border-radius: 10px !important;
      background-color: color-mix(in srgb, var(--background-color), #f5f8fd 30%) !important;
      border: 1px solid color-mix(in srgb, var(--default-color), transparent 90%) !important;
      color: var(--default-color) !important;
    }
    .btn-style{
        margin-top: 10px !important;
        padding: 13px 30px !important;
        background-color: #04415f !important;
        border: none !important;
        border-radius: 5% !important;
        color: white !important;
    }
  </style>
</head>

<body class="contact-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">

      <a href="{{route('landing_page')}}" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">School</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{route('landing_page')}}" class="active">Home</a></li>
          <li><a href="{{route('student_contact')}}">Contact</a></li>
          <a href="{{ route('student.register') }}" class="btn btn-success px-4 py-3 fw-bold text-white">
            Sign Up
          </a>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>    

    </div>
  </header>

  <main class="main">

    <!-- Contact Section -->
    <section id="contact" class="contact section" style="padding:0!important;">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="contact-main-wrapper d-flex justify-content-center align-items-center">
          <div class="contact-content">
            <div class="contact-form-container" data-aos="fade-up" data-aos-delay="400">
              <h2>Login</h2>
              <form action="{{route('student.login.submit')}}" method="post">
                @csrf
                <div class="row">
                  <div class="col-md-12 form-group pb-2">
                    <input type="email" name="email" class="form-control inp-style" id="name" placeholder="Enter Email *" required="required">
                  </div>
                  <div class="col-md-12 form-group pb-2">
                    <input type="password" name="password" class="form-control inp-style" id="name" placeholder="Enter Password *" required="required">
                  </div>
                </div>

                <div class="form-submit" style="float:right;">
                  <button type="submit" class="btn-style">Login</button>
                </div>
              </form>
              
            </div>
            <div>
                <p style="float:right;">Not have an account? <a href="{{route('student.register')}}">Register</a></p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Contact Section -->

  </main>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

 <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{asset('assets/js-front/main.js')}}"></script>

</body>

</html>