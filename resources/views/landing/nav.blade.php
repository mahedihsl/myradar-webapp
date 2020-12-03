<nav id="navigation" class="navbar" style="padding: 0 0;">

	<!-- .container -->
	<div class="container py-2">

		<p class="py-2" style="border-bottom: 1px solid #f2f7ff25;">Sales: +8801907888839 &nbsp;&nbsp; |
			&nbsp;&nbsp; Support: +8801907888899</p>
		<div class="navbar-brand flex flex-row items-center">
			<a href="{{ route('welcome') }}">
				<img src="{{ asset('images/web_logo.png') }}" alt="Logo">
			</a> <!-- site logo -->
			<span class="ml-2">myRADAR</span>
		</div>

		<ul class="nav navbar-nav">
			<li><a href="#header" class="">Home</a></li>
			<li><a href="#features" class="">Features</a></li>
			{{-- <li><a href="#testimonials" class="">Testimonials</a></li> --}}
			<li><a href="#screenshots" class="">Screenshots</a></li>
			<li><a href="#pricing" class="">Pricing</a></li>
			<li class="menu-btn">
				@if (Auth::check())
				<a href="{{ route('home') }}">Dashboard</a>
				@else
				<a href="{{ route('login') }}">Login</a>
				@endif
			</li>
		</ul>

	</div>
	<!-- .container end -->

</nav>