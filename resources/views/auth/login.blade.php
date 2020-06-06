<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap material admin template">
  <meta name="author" content="">

  <title>Login | My Radar</title>

  <link rel="apple-touch-icon" href="{{ asset('auth/images/apple-touch-icon.png') }}">
  <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('auth/global/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/css/bootstrap-extend.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/css/site.min.css') }}">

  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('auth/global/vendor/animsition/animsition.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/vendor/asscrollable/asScrollable.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/vendor/switchery/switchery.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/vendor/intro-js/introjs.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/vendor/slidepanel/slidePanel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/vendor/flag-icon-css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/vendor/waves/waves.min.css') }}">

  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('auth/examples/css/pages/login-v3.min.css') }}">

  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('auth/global/fonts/material-design/material-design.min.css') }}">
  <link rel="stylesheet" href="{{ asset('auth/global/fonts/brand-icons/brand-icons.min.css') }}">
  <link rel='stylesheet' href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,700">

  <!-- Scripts -->
  <script src="{{ asset('auth/global/vendor/breakpoints/breakpoints.min.js') }}"></script>
  <script>
    Breakpoints();
  </script>
</head>
<body class="animsition page-login-v3 layout-full">

  <!-- Page -->
  <div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <div class="panel">
        <div class="panel-body">
          <div class="brand">
            <img class="brand-img" src="{{ asset('images/web_logo.png') }}" alt="..." style="width: 60px;">
            <h2 class="brand-text font-size-18">My Radar</h2>
          </div>
          <form method="post" action="{{ route('login') }}" autocomplete="off">
            <div class="form-group form-material floating" data-plugin="formMaterial">
              <input type="text" class="form-control" name="username" value="{{ old('username') }}"/>
              <label class="floating-label">Email or Phone</label>
              @if ($errors->has('username'))
                 <span class="help-block text-danger">
                     {{ $errors->first('username') }}
                 </span>
             @endif 
            </div>
            <div class="form-group form-material floating" data-plugin="formMaterial">
              <input type="password" class="form-control" name="password" />
              <label class="floating-label">Password</label>
              @if ($errors->has('password'))
                 <span class="help-block text-danger">
                     {{ $errors->first('password') }}
                 </span>
             @endif
            </div>
            <div class="form-group clearfix">
              <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">
                <input type="checkbox" id="inputCheckbox" name="remember">
                <label for="inputCheckbox">Remember me</label>
              </div>
              <a class="float-right" href="#">Forgot password ?</a>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Sign in</button>
          </form>
          {{-- <p>Still no account? Please go to <a href="#">Sign up</a></p> --}}
        </div>
      </div>

      <footer class="page-copyright page-copyright-inverse">
        <p>HYPER SYSTEMS LIMITED</p>
        <p>© 2018. All RIGHT RESERVED.</p>
        {{-- <div class="social">
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-twitter" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-facebook" aria-hidden="true"></i>
          </a>
          <a class="btn btn-icon btn-pure" href="javascript:void(0)">
            <i class="icon bd-google-plus" aria-hidden="true"></i>
          </a>
        </div> --}}
      </footer>
    </div>
  </div>
  <!-- End Page -->

  <!-- Core  -->
  <script src="{{ asset('auth/global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/popper-js/umd/popper.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/animsition/animsition.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/mousewheel/jquery.mousewheel.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/asscrollbar/jquery-asScrollbar.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/asscrollable/jquery-asScrollable.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/ashoverscroll/jquery-asHoverScroll.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/waves/waves.min.js') }}"></script>

  <!-- Plugins -->
  <script src="{{ asset('auth/global/vendor/switchery/switchery.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/intro-js/intro.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/screenfull/screenfull.min.js') }}"></script>
  <script src="{{ asset('auth/global/vendor/slidepanel/jquery-slidePanel.min.js') }}"></script>

  <!-- Plugins For This Page -->
  <script src="{{ asset('auth/global/vendor/jquery-placeholder/jquery.placeholder.min.js') }}"></script>

  <!-- Scripts -->
  <script src="{{ asset('auth/global/js/State.min.js') }}"></script>
  <script src="{{ asset('auth/global/js/Component.min.js') }}"></script>
  <script src="{{ asset('auth/global/js/Plugin.min.js') }}"></script>
  <script src="{{ asset('auth/global/js/Base.min.js') }}"></script>
  <script src="{{ asset('auth/global/js/Config.min.js') }}"></script>

  <script src="{{ asset('auth/js/Section/Menubar.min.js') }}"></script>
  <script src="{{ asset('auth/js/Section/Sidebar.min.js') }}"></script>
  <script src="{{ asset('auth/js/Section/PageAside.min.js') }}"></script>
  <script src="{{ asset('auth/js/Plugin/menu.min.js') }}"></script>

  <!-- Config -->
  <script src="{{ asset('auth/global/js/config/colors.min.js') }}"></script>
  <script src="{{ asset('auth/js/config/tour.min.js') }}"></script>
  <script>
    Config.set('assets', '../assets');
  </script>

  <!-- Page -->
  <script src="{{ asset('auth/js/Site.min.js') }}"></script>
  <script src="{{ asset('auth/global/js/Plugin/asscrollable.min.js') }}"></script>

  <script src="{{ asset('auth/global/js/Plugin/slidepanel.min.js') }}"></script>
  <script src="{{ asset('auth/global/js/Plugin/switchery.min.js') }}"></script>

  <script src="{{ asset('auth/global/js/Plugin/jquery-placeholder.min.js') }}"></script>
  <script src="{{ asset('auth/global/js/Plugin/material.min.js') }}"></script>


  <script>
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;
      $(document).ready(function() {
        Site.run();
      });
    })(document, window, jQuery);
  </script>

</body>

</html>
