<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="app-url" content="/">

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- google font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

	<!-- aiz core css -->
	<link rel="stylesheet" href="{{ asset('assets/css/vendors.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/aiz-core.css') }}">


    <style>
        body {
            font-size: 12px;
        }
    </style>
	<script>
    	var AIZ = AIZ || {};
        AIZ.local = {}
	</script>

</head>
<body class="">

	<div class="aiz-main-wrapper">
        @include('inc.sidenav')
		<div class="aiz-content-wrapper">
            @include('inc.nav')
			<div class="aiz-main-content">
				<div class="px-15px px-lg-25px">
                    @yield('content')
				</div>
			</div><!-- .aiz-main-content -->
		</div><!-- .aiz-content-wrapper -->
	</div><!-- .aiz-main-wrapper -->

    @yield('modal')

	<script src="{{ asset('assets/js/vendors.js') }}" ></script>
	<script src="{{ asset('assets/js/aiz-core.js') }}" ></script>

    @yield('script')

	<script type="text/javascript">
	    @foreach (session('flash_notification', collect())->toArray() as $message)
	        AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
	    @endforeach
	</script>

</body>
</html>
