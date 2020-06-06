<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact V12</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{ asset('bikroy/images/icons/favicon.ico') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/animate/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/vendor/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('bikroy/css/main.css') }}">
</head>
<body>

	<div class="bg-contact100" style="background-image: url('/bikroy/images/bg-01.jpg');">
		<div class="container-contact100">
			<div class="wrap-contact100">
				<div class="contact100-pic js-tilt" data-tilt>
					<img src="{{asset('images/web_logo.png')}}" alt="myRADAR">
				</div>

				@if ($status == 1)
          <h2 class="text-success"><strong>We will contact you soon</strong></h2>
        @else
          <form class="contact100-form validate-form" action="/enroll/save" method="post">
            {!! csrf_field() !!}
  					<span class="contact100-form-title">
  						To Get 2000 Taka Discount register now
  					</span>

  					<div class="wrap-input100 validate-input" data-validate = "Name is required">
  						<input class="input100" type="text" name="name" placeholder="Name">
  						<span class="focus-input100"></span>
  						<span class="symbol-input100">
  							<i class="fa fa-user" aria-hidden="true"></i>
  						</span>
  					</div>

  					<div class="wrap-input100 validate-input" data-validate = "Phone number required">
  						<input class="input100" type="text" name="phone" placeholder="Mobile Number">
  						<span class="focus-input100"></span>
  						<span class="symbol-input100">
  							<i class="fa fa-phone" aria-hidden="true"></i>
  						</span>
  					</div>

            <div class="wrap-input100">
  						<input class="input100" type="text" name="email" placeholder="Email Address">
  						<span class="focus-input100"></span>
  						<span class="symbol-input100">
  							<i class="fa fa-envelope" aria-hidden="true"></i>
  						</span>
  					</div>

  					{{-- <div class="wrap-input100 validate-input" data-validate = "Message is required">
  						<textarea class="input100" name="message" placeholder="Message"></textarea>
  						<span class="focus-input100"></span>
  					</div> --}}

  					<div class="container-contact100-form-btn">
  						<button class="contact100-form-btn">
  							Send
  						</button>
  					</div>
						<div class="container-contact100-form-btn">
  						<span style="margin-right: 10px;">For Details, Visit Our</span> <a href="http://myradar.com.bd">Website</a>
  					</div>
  				</form>
        @endif
			</div>
		</div>
	</div>

	<script src="{{ asset('bikroy/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('bikroy/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('bikroy/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('bikroy/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('bikroy/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="{{ asset('bikroy/js/main.js') }}"></script>

</body>
</html>
