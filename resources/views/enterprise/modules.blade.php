<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Demo Enterprise Modules | myRADAR</title>

  <!-- Favicons -->
	<link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
	<link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png') }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png') }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png') }}">

  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
  <div class="w-full h-screen bg-blue-600 flex flex-row justify-center items-center space-x-8">
    <a href="/car/tracking" class="w-1/3 flex flex-col items-center justify-center space-y-6 py-6 bg-white rounded-xl shadow-xl hover:bg-gray-100 duration-300">
      <span class="text-gray-600 font-bold text-xl">Fleet Management</span>
      <img src="/images/redcar.svg" class="w-1/2 h-auto" alt="">
    </a>
    <a href="http://182.160.99.137:6022/vessel/tracking" target="_blank" class="w-1/3 flex flex-col items-center justify-center space-y-6 py-6 bg-white rounded-xl shadow-xl hover:bg-gray-100 duration-300">
      <span class="text-gray-600 font-bold text-xl">Vessel Management</span>
      <img src="/images/launch.svg" class="w-1/2 h-auto" alt="">
    </a>
  </div>
</body>
</html>