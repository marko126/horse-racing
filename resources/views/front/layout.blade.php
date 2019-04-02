<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>{{trans('front.main_title')}} - @yield('head_title')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- @todo: fill with your company info or remove -->
		<meta name="description" content="">
		<meta name="author" content="Cubes School">
		<!-- Bootstrap CSS -->
		<link href="{{url('/skins/front/plugins/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
		<!-- Font Awesome CSS -->
		<link href="{{url('/skins/front/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
		<!-- Theme style -->
		<link href="{{url('/skins/front/css/theme-style.css')}}" rel="stylesheet">
		<!-- Your custom override -->
		<link href="{{url('/skins/front/css/custom-style.css')}}" rel="stylesheet">
		<!-- @option: Colour skins, choose from: 1. colour-blue.css 2. colour-red.css 3. colour-grey.css 4. colour-purple 5. colour-green.css Uncomment line below to enable -->
		<link href="{{url('/skins/front/css/colour-blue.css')}}" rel="stylesheet" id="colour-scheme">
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="{{url('/skins/front/plugins/html5shiv/dist/html5shiv.js')}}"></script>
		<script src="{{url('/skins/front/plugins/respond/respond.min.js')}}"></script>
		<![endif]-->
		<!-- Le fav and touch icons - @todo: fill with your icons or remove -->
		<link rel="shortcut icon" href="{{url('/skins/front/img/favicons/96x96.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{url('/skins/front/img/favicons/114x114.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{url('/skins/front/img/favicons/72x72.png')}}">
		<link rel="apple-touch-icon-precomposed" href="{{url('/skins/front/img/favicons/96x96.png')}}">
		<link href='https://fonts.googleapis.com/css?family=Monda:400,700' rel='stylesheet' type='text/css'>
		
		@stack('head_css')
		@stack('head_javascript')
	</head>

	<!-- ======== @Region: body ======== -->
	<body class="has-navbar-fixed-top has-highlighted">

		<!-- ======== @Region: #navigation ======== -->
		@include('front.navigation')

		<!-- ======== @Region: #highlighted ======== -->
		
		@yield('content')
		
		<!-- ======== @Region: #footer ======== -->
		@include('front.footer')
		<!--Scripts -->
		<script src="{{url('/skins/front/js/jquery.js')}}"></script>
		<!-- Bootstrap Javascript -->
		<script src="{{url('/skins/front/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
		
		@stack('footer_javascript')
	</body>

</html>