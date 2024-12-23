<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>PH - {{ $title }}</title>

        {{-- Fonts --}}
		<link href="https://fonts.googleapis.com" rel="preconnect">
		<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

        {{-- Stylesheets --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
		@vite('resources/css/app.css')
	</head>

	<body class="flex min-h-screen">
		{{ $slot }}
	</body>

</html>
