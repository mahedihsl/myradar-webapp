<nav id="navigation" class="navbar" style="padding: 0 0;">

	<div class="w-full py-8 px-4 md:px-32 flex flex-col items-center shadow-lg" style="background-color: #0c2461;">
		<div class="w-full flex flex-row justify-center items-center px-8">
			<img class="w-8 h-8 tada" src="{{ asset('images/ic_confetti.svg') }}" alt="" />
			<span class="tada font-semibold text-white text-xl ml-8">New Product</span>
		</div>

		<div class="w-full flex flex-col md:flex-row items-center mt-4 md:mt-0">
			<div class="flex-shrink-0">
				<img class="w-auto h-24 rounded" src="{{ asset('images/e-heater.png') }}" alt="" />
			</div>
			<div class="flex flex-col pl-6 flex-grow py-4 md:py-0">
				<span class="text-white font-bold text-4xl">
					e-Heater
				</span>
				<p class="w-full font-light text-white leading-tight" style="font-size: 18px;">
					মোবাইল App এর মাধ্যমে গাড়ির ইঞ্জিন অন করে দ্রুতগতিতে গরম করুন । বারবার ব্যাটারি বসে যাওয়ার সমস্যার স্থায়ী
					সমাধান।
				</p>
			</div>
			<div class="flex-shrink-0">
				<button id="btn-e-heater"
					class="font-normal text-white bg-pink-500 hover:bg-pink-500 uppercase px-8 py-4 rounded border border-pink-500 text-xl shadow-lg transition-300">
					See More
				</button>
			</div>
		</div>
	</div>

	<!-- .container -->
	<div class="container">

		<p style="padding-bottom: 10px; border-bottom: 1px solid #f2f7ff25;">Sales: +8801907888839 &nbsp;&nbsp; |
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